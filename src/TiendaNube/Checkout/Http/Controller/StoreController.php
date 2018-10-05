<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Controller;

use TiendaNube\Checkout\Model\Store;

/**
 * Class StoreController
 *
 * @package TiendaNube\Checkout\Controller
 */
class StoreController : StoreServiceInterface
{

    private Store $store;

    public function getCurrentStore():Store{

        int $idStore = $_SESSION['idStore'];

        $this->logger->debug('Getting store with id [' . $idStore . '] from database');

        try {
            $stmt = $this->connection->prepare('SELECT * FROM `stores` WHERE `id` = ?');
            $stmt->execute([$idStore]);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                $this->store->setId($row['id']);

                $this->store->setName($row['name']);

                $this->store->setEmail($row['email']);

                if($row['betaTester']){
                    $this->store->enableBetaTesting();
                }
            }

        } catch (\PDOException $ex) {
            $this->logger->error(
                'An error occurred at try to fetch the store from the database, exception with message was caught: ' .
                $ex->getMessage()
            );

        }

    }

    public function __construct() {
        $this->store = $this->getCurrentStore();
    }

    public function getStore():void{
        return $this->store;
    }

    function isBetaTester():boolean{
        return $this->store->isBetaTester();
    }
}
