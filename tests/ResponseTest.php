<?php

namespace Etiqa\MotorInsurance\TestCase;

use Etiqa\MotorInsurance\Response;
use Laravie\Codex\Testing\Faker;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_can_be_validated()
    {
        $faker = Faker::create()
                    ->shouldResponseWith(200, '{"status":"OK"}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $response = (new Response($faker->message()))->validate();

        $this->assertInstanceOf(Response::class, $response);
    }

    /** @test */
    public function it_can_be_validate_unauthorized()
    {
        $this->expectException('Etiqa\MotorInsurance\Exceptions\NotAuthorizedException');
        $this->expectExceptionMessage('Not authorized.');

        $faker = Faker::create()
                    ->shouldResponseWith(401)
                    ->expectReasonPhraseIs('Not authorized.');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        (new Response($faker->message()))->validate();
    }

    /** @test */
    public function it_can_be_validate_server_errors()
    {
        $this->expectException('Laravie\Codex\Exceptions\HttpException');
        $this->expectExceptionMessage('Server not available!');

        $faker = Faker::create()
                    ->shouldResponseWith(500, '{"status":"ERROR","message":"Server not available!"}');

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        $response = (new Response($faker->message()))->validate();
    }

    /** @test */
    public function it_can_be_validate_generic_errors()
    {
        $this->expectException('Laravie\Codex\Exceptions\HttpException');
        $this->expectExceptionMessage("I'm a teapot");

        $faker = Faker::create()
                    ->shouldResponseWith(418)
                    ->expectReasonPhraseIs("I'm a teapot");

        $faker->message()->shouldReceive('getHeader')->once()->andReturn(['application/json']);

        (new Response($faker->message()))->validate();
    }
}
