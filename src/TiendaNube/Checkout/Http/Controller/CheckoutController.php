<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use TiendaNube\Checkout\Service\Shipping\AddressService;

class CheckoutController extends AbstractController
{

    public function getStore():Store{
        return new Store();
    }

    /**
     * Returns the address to be auto-fill the checkout form
     *
     * Expected JSON:
     * {
     *     "address": "Avenida da França",
     *     "neighborhood": "Comércio",
     *     "city": "Salvador",
     *     "state": "BA"
     * }
     *
     * @Route /address/{zipcode}
     *
     * @param string $zipcode
     * @param AddressService $addressService
     * @return ResponseInterface
     */
    public function getAddressAction(string $zipcode, AddressService $addressService):ResponseInterface {
        // filtering and sanitizing input
        $rawZipcode = preg_replace("/[^\d]/","",$zipcode);

        $store = $this->getStore();

        if($store->isBetaTester()){
            $address = $addressService->getAddressByZipNew($rawZipcode);
        }else{
            $address = $addressService->getAddressByZip($rawZipcode);
        }

        if (!is_null($address['json'])) {
            return $this->json($address['json']);
        }

        return $this->json(['error'=>$address['error']],$address['status_code']);
    }
}
