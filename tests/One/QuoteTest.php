<?php

namespace Etiqa\MotorInsurance\TestCase\One;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\FakeRequest;

class QuoteTest extends TestCase
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
            'coverage_type' => 'MT',
            'id_type' => '1',
            'id_value' => '820101015510',
            'vehicle_postcode' => '50000',
            'vehicle_reg_no' => 'ABC123',
            'drivers' => [
                ['email' => 'demo.etiqa@gmail.com'],
            ],
            'agent_code' => 'agent',
            'operator_code' => 'operator',
        ];

        $faker = FakeRequest::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/quote')
                    ->shouldResponseWith(200, '{"code":"A038","message":"Driver record incomplete. Please provide details","status":"ERROR","data":null}');

        $client = new Client($faker->http(), 'id', 'secret');
        $client->setAccessToken('abc');

        $client->uses('Quote')->submit($payload);
    }
}