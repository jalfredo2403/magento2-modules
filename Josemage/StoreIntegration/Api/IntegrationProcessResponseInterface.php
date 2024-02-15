<?php

namespace Josemage\StoreIntegration\Api;

use Psr\Http\Message\ResponseInterface;

/**
 *
 */
interface IntegrationProcessResponseInterface
{

    /**
     * @param ResponseInterface $response
     * @return string
     */
    public function formatResponse(ResponseInterface $response): string;

}
