<?php

namespace Etiqa\MotorInsurance\TestCase\One;

use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\FakeRequest;
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

    /**
     * @test
     * @expectedException \Etiqa\MotorInsurance\Exceptions\RequestHasFailedException
     * @expectedExceptionMessage Driver record incomplete. Please provide details
     */
    public function it_can_throws_exception_when_status_is_errors()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer abc',
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

        $faker = FakeRequest::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/policy')
                    ->shouldResponseWith(200, '{"code":"A038","message":"Driver record incomplete. Please provide details","status":"ERROR","data":null}');

        $client = new Client($faker->http(), 'id', 'secret');
        $client->setAccessToken('abc');

        $client->uses('Policy')->submit($payload);
    }
}
