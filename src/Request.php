<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Endpoint;
use Laravie\Codex\Request as BaseRequest;

abstract class Request extends BaseRequest
{
    /**
     * Get API Header.
     *
     * @return array
     */
    protected function getApiHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        if (! is_null($accessToken = $this->client->getAccessToken())) {
            $headers['Authorization'] = "Bearer {$accessToken}";
        }

        return $headers;
    }

    /**
     * Get API Endpoint.
     *
     * @param string|array $path
     *
     * @return \Laravie\Codex\Endpoint
     */
    protected function getApiEndpoint($path = [])
    {
        $host = $this->client->getApiEndpoint();

        return new Endpoint("{$host}/api/{$this->version}/my/insurance", $path);
    }
}
