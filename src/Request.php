<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Concerns\Request\Json;
use Laravie\Codex\Request as BaseRequest;

abstract class Request extends BaseRequest
{
    use Json;

    /**
     * Get API Header.
     *
     * @return array
     */
    protected function getApiHeaders(): array
    {
        $headers = [];

        if (! is_null($accessToken = $this->client->getAccessToken())) {
            $headers['Authorization'] = "Bearer {$accessToken}";
        }

        return $headers;
    }
}
