<?php

namespace Etiqa\MotorInsurance\Tests;

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
                    ->shouldResponseWithJson(200, '{"status":"OK"}');

        $response = (new Response($faker->message()))->validate();

        $this->assertInstanceOf(Response::class, $response);
    }

    /** @test */
    public function it_can_be_validate_unauthorized()
    {
        $this->expectException('Etiqa\MotorInsurance\Exceptions\NotAuthorizedException');
        $this->expectExceptionMessage('Not authorized.');

        $faker = Faker::create()
                    ->shouldResponseWithJson(401)
                    ->expectReasonPhraseIs('Not authorized.');

        (new Response($faker->message()))->validate();
    }

    /** @test */
    public function it_can_be_validate_server_errors()
    {
        $this->expectException('Laravie\Codex\Exceptions\HttpException');
        $this->expectExceptionMessage('Server not available!');

        $faker = Faker::create()
                    ->shouldResponseWithJson(500, '{"status":"ERROR","message":"Server not available!"}');

        $response = (new Response($faker->message()))->validate();
    }

    /** @test */
    public function it_can_be_validate_generic_errors()
    {
        $this->expectException('Laravie\Codex\Exceptions\HttpException');
        $this->expectExceptionMessage("I'm a teapot");

        $faker = Faker::create()
                    ->shouldResponseWithJson(418)
                    ->expectReasonPhraseIs("I'm a teapot");

        (new Response($faker->message()))->validate();
    }
}
