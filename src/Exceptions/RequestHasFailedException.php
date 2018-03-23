<?php

namespace Etiqa\MotorInsurance\Exceptions;

use Laravie\Codex\Contracts\Response;
use Laravie\Codex\Exceptions\HttpException;

class RequestHasFailedException extends HttpException
{
    /**
     * Response error code.
     *
     * @var string|null
     */
    private $responseErrorCode;

    /**
     * Construct a new HTTP exception.
     *
     * @param \Laravie\Codex\Contracts\Response $response
     * @param string                            $message
     * @param string                            $errorCode
     */
    public function __construct(Response $response, string $message, string $errorCode)
    {
        parent::__construct($response, $message);

        $this->responseErrorCode = $errorCode;
    }

    /**
     * Get response error code.
     *
     * @return string
     */
    public function getResponseErrorCode(): string
    {
        return $this->responseErrorCode;
    }
}
