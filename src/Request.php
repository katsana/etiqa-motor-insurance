<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Concerns\Request\Json;
use Laravie\Codex\Contracts\Response as ResponseContract;
use Laravie\Codex\Request as BaseRequest;
use Psr\Http\Message\ResponseInterface;

abstract class Request extends BaseRequest
{
    use Json;

    /**
     * Resolve the responder class.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    protected function responseWith(ResponseInterface $response): ResponseContract
    {
        return new Response($response);
    }

    /**
     * Get API Header.
     *
     * @return array
     */
    protected function getApiHeaders(): array
    {
        $headers = [];

        if (! \is_null($accessToken = $this->client->getAccessToken())) {
            $headers['Authorization'] = "Bearer {$accessToken}";
        }

        return $headers;
    }
}
