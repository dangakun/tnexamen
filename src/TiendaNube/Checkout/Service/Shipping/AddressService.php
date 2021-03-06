<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use Psr\Log\LoggerInterface;

/**
 * Class AddressService
 *
 * @package TiendaNube\Checkout\Service\Shipping
 */
class AddressService
{
    /**
     * The database connection link
     *
     * @var \PDO
     */
    private $connection;

    private $logger;

    /**
     * AddressService constructor.
     *
     * @param \PDO $pdo
     * @param LoggerInterface $logger
     */
    public function __construct(\PDO $pdo, LoggerInterface $logger)
    {
        $this->connection = $pdo;
        $this->logger = $logger;
    }

    /**
     * Get an address by its zipcode (CEP)
     *
     * The expected return format is an array like:
     * [
     *      "address" => "Avenida da França",
     *      "neighborhood" => "Comércio",
     *      "city" => "Salvador",
     *      "state" => "BA"
     * ]
     * or false when not found.
     *
     * @param string $zip
     * @return bool|array
     */
    public function getAddressByZip(string $zip): ?array
    {
        $this->logger->debug('Getting address for the zipcode [' . $zip . '] from database');

        $ret = array('error'='The requested zipcode was not found.','error_code'=>404,'json'=>null);

        try {
            // getting the address from database
            $stmt = $this->connection->prepare('SELECT * FROM `addresses` WHERE `zipcode` = ?');
            $stmt->execute([$zip]);

            // checking if the address exists
            if ($stmt->rowCount() > 0) {
                $ret['error'] = '';
                $ret['error_code'] = 0;
                $ret['json'] = $stmt->fetch(\PDO::FETCH_ASSOC);
            }

            return $ret;
        } catch (\PDOException $ex) {
            $this->logger->error(
                'An error occurred at try to fetch the address from the database, exception with message was caught: ' .
                $ex->getMessage()
            );

            return $ret;
        }
    }

    public function getAddressByZipNew(string $zip): ?array
    {
        $this->logger->debug('Getting address for the zipcode [' . $zip . '] from API');

        $serv_url = 'https://shipping.tiendanube.com/address/'.$zip;
        $curl = curl_init($serv_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);

        $ret = array('error'='','status_code'=>0,'json'=>null);

        $response = $curl_response;

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $ret['status_code'] = $httpCode;

        curl_close($curl);

        switch($httpCode){
            case 200:
                $ret['json'] = $response;
            break;

            case 404:
                $ret['error'] = 'The requested zipcode was not found.';
            break;

            case 500:
                $ret['error'] = 'Internal Server Error';
            break;
        }

        return $ret;
    }

}
