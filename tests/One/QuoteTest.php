<?php

namespace Etiqa\MotorInsurance\TestCase\One;

use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\Faker;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class QuoteTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_submit_quotation()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
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

        $faker = Faker::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/quote')
                    ->shouldResponseWith(200, '{"status":"OK","data":null}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Quote')->submit($payload);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
    }

    /** @test */
    public function it_can_throws_exception_when_status_is_errors()
    {
        $this->expectException('Etiqa\MotorInsurance\Exceptions\RequestHasFailedException');
        $this->expectExceptionMessage('Driver record incomplete. Please provide details');

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
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

        $faker = Faker::create()
                    ->call('POST', $headers, json_encode($payload))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/quote')
                    ->shouldResponseWith(200, '{"code":"A038","message":"Driver record incomplete. Please provide details","status":"ERROR","data":null}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $client->uses('Quote')->submit($payload);
    }

    /** @test */
    public function it_can_create_quick_quotation_draft()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
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

        $faker = Faker::create()
                    ->call('POST', $headers, json_encode(array_merge($payload, ['quick_quote' => true])))
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/quote')
                    ->shouldResponseWith(200, '{"status":"OK","data":null}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Quote')->draft($payload);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
    }
}
