<?php

namespace Etiqa\MotorInsurance\One;

use Etiqa\MotorInsurance\Request as BaseRequest;
use Laravie\Codex\Contracts\Endpoint as EndpointContract;
use Laravie\Codex\Endpoint;

abstract class Request extends BaseRequest
{
    /**
     * Version namespace.
     *
     * @var string
     */
    protected $version = 'v1.0';

    /**
     * Get API Endpoint.
     *
     * @param string|array $path
     *
     * @return \Laravie\Codex\Contracts\Endpoint
     */
    protected function getApiEndpoint($path = []): EndpointContract
    {
        $host = $this->client->getApiEndpoint();

        return new Endpoint("{$host}/api/{$this->version}/my/insurance", $path);
    }
}
