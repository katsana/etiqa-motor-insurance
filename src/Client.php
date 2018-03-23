<?php

namespace Etiqa\MotorInsurance;

use Laravie\Codex\Client as BaseClient;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Laravie\Codex\Contracts\Response as ResponseContract;

class Client extends BaseClient
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
     * The API endpoint.
     *
     * @var string
     */
    protected $apiEndpoint;

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
     * @param \Http\Client\Common\HttpMethodsClient  $http
     * @param string  $clientId
     * @param string  $clientSecret
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
    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Resolve the responder class.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    protected function responseWith(ResponseInterface $response): ResponseContract
    {
        return new Response($response);
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
     * @param  string  $endpoint
     *
     * @return $this
     */
    public function useCustomPassportEndpoint($endpoint): self
    {
        $this->passportEndpoint = $endpoint;

        return $this;
    }
}
