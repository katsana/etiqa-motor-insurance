<?php

namespace Etiqa\MotorInsurance;

use Http\Client\Common\HttpMethodsClient as HttpClient;

class Client extends \Laravie\Codex\Client
{
    /**
     * API Key.
     *
     * @var string
     */
    protected $clientId;

    /**
     * API Secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * API Access Token.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * The Passport (OAuth2) endpoint.
     *
     * @var string
     */
    protected $passportEndpoint;

    /**
     * List of supported API versions.
     *
     * @var array
     */
    protected $supportedVersions = [
        'v1' => 'One',
    ];

    /**
     * Construct a new Client.
     *
     * @param \Http\Client\Common\HttpMethodsClient $http
     * @param string                                $clientId
     * @param string                                $clientSecret
     */
    public function __construct(HttpClient $http, string $clientId, string $clientSecret)
    {
        $this->http = $http;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Get API Key.
     *
     * @return string|null
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Get API Secret.
     *
     * @return string|null
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Get passport endpoint.
     *
     * @return string
     */
    public function getPassportEndpoint(): string
    {
        return $this->passportEndpoint;
    }

    /**
     * Get access token.
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Set access token.
     *
     * @param string|null $accessToken
     *
     * @return $this
     */
    public function setAccessToken(?string $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get resource default namespace.
     *
     * @return string
     */
    protected function getResourceNamespace(): string
    {
        return __NAMESPACE__;
    }

    /**
     * Use custom Passport Endpoint.
     *
     * @param string $endpoint
     *
     * @return $this
     */
    public function useCustomPassportEndpoint(string $endpoint)
    {
        $this->passportEndpoint = $endpoint;

        return $this;
    }
}
