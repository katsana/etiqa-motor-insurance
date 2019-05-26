<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Exceptions\HttpException;

class Response extends \Laravie\Codex\Response
{
    /**
     * Validate the response object.
     *
     * @return $this
     */
    public function validate()
    {
        $payload = $this->toArray();
        $statusCode = $this->getStatusCode();
        $contentType = $this->getHeader('Content-Type')[0] ?? null;

        if ($statusCode === 401) {
            throw new Exceptions\NotAuthorizedException($this, $this->getReasonPhrase());
        } elseif ($statusCode === 500 && $contentType === 'application/json') {
            throw new HttpException($this, $this->toArray()['message']);
        } elseif ($statusCode !== 200) {
            throw new HttpException($this, $this->getReasonPhrase());
        } elseif ($payload['status'] == 'ERROR' && $statusCode === 200) {
            throw new Exceptions\RequestHasFailedException($this, $payload['message'], $payload['code']);
        }

        return $this;
    }
}
