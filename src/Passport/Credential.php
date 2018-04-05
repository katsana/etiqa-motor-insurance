<?php

namespace Etiqa\MotorInsurance\Passport;

use Laravie\Codex\Contracts\Response;

class Credential extends Request
{
    /**
     * Create access token.
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function createAccessToken(): Response
    {
        return $this->send('POST', 'token', $this->getApiHeaders(), $this->getApiBody());
    }

    /**
     * Get API Body.
     *
     * @return array
     */
    protected function getApiBody(): array
    {
        return [
            'scope' => '/motor',
            'grant_type' => 'client_credentials',
            'client_id' => $this->client->getClientId(),
            'client_secret' => $this->client->getClientSecret(),
        ];
    }
}
