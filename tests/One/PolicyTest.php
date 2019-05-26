<?php

namespace Etiqa\MotorInsurance\TestCase\One;

use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\Faker;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class PolicyTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_submit_policy()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
        ];

        $payload = [
            'declaration' => [
                'pds' => true,
                'ind' => true,
                'pdpa' => true,
                'lapse' => false,
            ],
            'pay_flag' => 'BFR',
            'payment' => null,
            'tx' => [
                'ref' => 'TXREF',
            ],
        ];

        $faker = Faker::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/policy')
                    ->shouldResponseWith(200, '{"status":"OK","data":null}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Policy')->submit($payload);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
    }
}
