<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ResponseBuilderInterface
 *
 * @package TiendaNube\Checkout\Http\Response
 */
interface ResponseBuilderInterface
{
    /**
     * Factory a Response object
     *
     * @param mixed $body
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    public function buildResponse($body, int $status = 200, array $headers = []):ResponseInterface;
}
