<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Request;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface RequestStackInterface
 *
 * @package TiendaNube\Checkout\Http\Request
 */
interface RequestStackInterface
{
    /**
     * Get the current request object
     *
     * @return ServerRequestInterface
     */
    public function getCurrentRequest():ServerRequestInterface;
}
