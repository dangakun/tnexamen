<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TiendaNube\Checkout\Http\Request\RequestStackInterface;
use TiendaNube\Checkout\Http\Response\ResponseBuilderInterface;

/**
 * Class AbstractController
 *
 * @package TiendaNube\Checkout\Controller
 */
abstract class AbstractController
{
    /**
     * DependencyInjection container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * The RequestStack object
     *
     * @var RequestStackInterface
     */
    private $requestStack;

    /**
     * The ResponseBuilder
     *
     * @var ResponseBuilderInterface
     */
    private $responseBuilder;

    /**
     * AbstractController constructor.
     *
     * @param ContainerInterface $container
     * @param RequestStackInterface $requestStack
     * @param ResponseBuilderInterface $responseBuilder
     */
    public function __construct(
        ContainerInterface $container,
        RequestStackInterface $requestStack,
        ResponseBuilderInterface $responseBuilder
    ) {
        $this->container = $container;
        $this->requestStack = $requestStack;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * Get the current request
     *
     * @return ServerRequestInterface
     */
    protected function getCurrentRequest():ServerRequestInterface {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Get the DependencyInjection container
     *
     * @return ContainerInterface
     */
    protected function getContainer():ContainerInterface {
        return $this->container;
    }

    /**
     * Get a JsonResponse object
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return ResponseInterface
     */
    protected function json(array $data, int $status = 200, array $headers = []):ResponseInterface {
        return $this->responseBuilder->buildResponse(json_encode($data),$status,$headers);
    }
}
