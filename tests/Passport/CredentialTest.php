<?php

namespace Etiqa\MotorInsurance\Tests\Passport;

use Etiqa\MotorInsurance\Client;
use Etiqa\MotorInsurance\Passport\Credential;
use Laravie\Codex\Testing\Faker;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class CredentialTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_authenticate_user()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'scope' => '/motor',
            'grant_type' => 'client_credentials',
            'client_id' => 'homestead',
            'client_secret' => 'secret',
        ];

        $faker = Faker::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('https://api.etiqa.com.my/passport/api/v1.0/my/oauth/token')
                    ->shouldResponseWith(200, '{"status":"OK","data":{"access_token":"AckfSECXIvnK5r28GVIWUAxmbBSjTsmF"}}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->useCustomPassportEndpoint('https://api.etiqa.com.my/passport');
        $client->setAccessToken(null);

        $response = $client->via(new Credential($client))->createAccessToken();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
        $this->assertSame(['access_token' => 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF'], $response->toArray()['data']);
    }
}
