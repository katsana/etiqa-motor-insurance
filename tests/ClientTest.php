<?php

namespace Etiqa\MotorInsurance\TestCase;

use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\FakeRequest;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_has_proper_signature()
    {
        $faker = FakeRequest::create();

        $client = new Client($faker->http(), 'id', 'secret');

        $this->assertSame('id', $client->getClientId());
        $this->assertSame('secret', $client->getClientSecret());

        $this->assertNull($client->getAccessToken());
    }

    /** @test */
    public function it_can_use_custom_passport_endpoint()
    {
        $faker = FakeRequest::create();

        $client = new Client($faker->http(), 'id', 'secret');

        $client->useCustomPassportEndpoint('https://api.etiqa.com.my/oauth');

        $this->assertSame('https://api.etiqa.com.my/oauth', $client->getPassportEndpoint());
    }

    /** @test */
    public function it_can_set_access_token()
    {
        $faker = FakeRequest::create();

        $client = new Client($faker->http(), 'id', 'secret');

        $this->assertNull($client->getAccessToken());

        $client->setAccessToken('abc');

        $this->assertSame('abc', $client->getAccessToken());
    }
}
