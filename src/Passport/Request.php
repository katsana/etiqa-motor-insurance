<?php

namespace Etiqa\MotorInsurance\Passport;

use Laravie\Codex\Endpoint;
use Etiqa\MotorInsurance\Request as BaseRequest;

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
     * @return \Laravie\Codex\Endpoint
     */
    protected function getApiEndpoint($path = [])
    {
        $host = $this->client->getPassportEndpoint();

        return new Endpoint("{$host}/api/{$this->version}/my/oauth", $path);
    }
}