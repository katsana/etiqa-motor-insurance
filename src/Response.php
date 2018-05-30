<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Exceptions\HttpException;
use Laravie\Codex\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * Validate the response object.
     *
     * @return $this
     */
    public function validate(): BaseResponse
    {
        $payload = $this->toArray();
        $statusCode = $this->getStatusCode();

        if ($statusCode === 401) {
            throw new Exceptions\NotAuthorizedException($this, $this->getReasonPhrase());
        } elseif ($statusCode === 500) {
            throw new HttpException($this, $this->toArray()['message']);
        } elseif ($statusCode !== 200) {
            throw new HttpException($this, $this->getReasonPhrase());
        } elseif ($payload['status'] == 'ERROR' && $statusCode === 200) {
            throw new Exceptions\RequestHasFailedException($this, $payload['message'], $payload['code']);
        }

        return $this;
    }
}
