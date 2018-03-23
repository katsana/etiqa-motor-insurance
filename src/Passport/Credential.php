<?php

namespace Etiqa\MotorInsurance\Passport;

class Credential extends Request
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
