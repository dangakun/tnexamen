<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Model;

/**
 * Class Store
 *
 * @package TiendaNube\Checkout\Model
 */
class Store
{
    /**
     * The store's id
     *
     * @var int
     */
    private $id;

    /**
     * The store's name
     *
     * @var string
     */
    private $name;

    /**
     * The store's owner e-mail address
     *
     * @var string
     */
    private $email;

    /**
     * The store's beta tester status
     *
     * @var bool
     */
    private $betaTester = false;

    /**
     * Get the current store ID
     *
     * @return int
     */
    public function getId():int {
        return $this->id;
    }

    /**
     * Set the store's name
     *
     * @param string $name
     */
    public function setName(string $name):void {
        $this->name = $name;
    }

    /**
     * Get the current store name
     *
     * @return string
     */
    public function getName():string {
        return $this->name;
    }

    /**
     * Sets the store's e-mail address
     *
     * @param string $email
     */
    public function setEmail(string $email):void {
        $this->email = $email;
    }

    /**
     * Get the current store e-mail address
     * @return string
     */
    public function getEmail():string {
        return $this->email;
    }

    /**
     * Check if the current store is a beta tester
     *
     * @return bool
     */
    public function isBetaTester():bool {
        return $this->betaTester;
    }

    /**
     * Enables store beta testing
     */
    public function enableBetaTesting():void {
        $this->betaTester = true;
    }

    /**
     * Disables store beta testing
     */
    public function disableBetaTesting():void {
        $this->betaTester = false;
    }
}
