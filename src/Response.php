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
    public function validate(): self
    {
        $payload = $this->toArray();

        if ($this->getStatusCode() === 401) {
            throw new Exceptions\NotAuthorizedException($this, $this->getReasonPhrase());
        } elseif ($this->getStatusCode() === 500) {
            throw new HttpException($this, $this->toArray()['message']);
        } elseif ($this->getStatusCode() !== 200) {
            throw new HttpException($this, $this->getReasonPhrase());
        } elseif ($payload['status'] == 'ERROR' && $this->getStatusCode() === 200) {
            throw new Exceptions\RequestHasFailedException($this, $payload['message'], $payload['code']);
        }

        return $this;
    }
}
