<?php

namespace Etiqa\MotorInsurance\TestCase\One;

use Etiqa\MotorInsurance\Client;
use Laravie\Codex\Testing\Faker;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_get_vehicle_lists()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
        ];

        $faker = Faker::create()
                    ->call('GET', $headers, m::any())
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/vehicles')
                    ->shouldResponseWith(200, '{"status":"OK","data":[]}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Vehicles')->all();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
        $this->assertSame([], $response->toArray()['data']);
    }

    /** @test */
    public function it_can_get_vehicle_lists_by_make()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
        ];

        $faker = Faker::create()
                    ->call('GET', $headers, m::any())
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/vehicles/ABC')
                    ->shouldResponseWith(200, '{"status":"OK","data":[]}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Vehicles')->make('ABC');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
        $this->assertSame([], $response->toArray()['data']);
    }

    /** @test */
    public function it_can_get_vehicle_variations()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer AckfSECXIvnK5r28GVIWUAxmbBSjTsmF',
        ];

        $faker = Faker::create()
                    ->call('GET', $headers, m::any())
                    ->expectEndpointIs('/api/v1.0/my/insurance/motor/vehicles/ABC/123/2011')
                    ->shouldResponseWith(200, '{"status":"OK","data":[]}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $client = new Client($faker->http(), 'homestead', 'secret');
        $client->setAccessToken('AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');

        $response = $client->uses('Vehicles')->show('ABC', '123', 2011);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->toArray()['status']);
        $this->assertSame([], $response->toArray()['data']);
    }
}
