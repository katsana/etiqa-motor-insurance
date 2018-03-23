<?php

namespace Etiqa\MotorInsurance\Passport;

use Laravie\Codex\Endpoint;
use Etiqa\MotorInsurance\Request as BaseRequest;

class Credential extends BaseRequest
{
    /**
     * Create access token.
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function createAccessToken()
    {
        return $this->send('POST', 'token', $this->getApiHeaders(), $this->getApiBody());
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
        return new Endpoint($this->client->getPassportEndpoint(), $path);
    }

    /**
     * Get API Body.
     *
     * @return array
     */
    protected function getApiBody()
    {
        return [
            'scope' => '/motor',
            'grant_type' => 'client_credentials',
            'client_id' => $this->client->getClientId(),
            'client_secret' => $this->client->getClientSecret(),
        ];
    }
}
