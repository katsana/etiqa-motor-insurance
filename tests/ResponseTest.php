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

        $response = (new Response($faker->message()))->validate();

        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test
     * @expectedException \Etiqa\MotorInsurance\Exceptions\NotAuthorizedException
     * @expectedExceptionMessage Not authorized.
     */
    public function it_can_be_validate_unauthorized()
    {
        $faker = Faker::create()
                    ->shouldResponseWith(401)
                    ->expectReasonPhraseIs('Not authorized.');

        (new Response($faker->message()))->validate();
    }

    /**
     * @test
     * @expectedException \Laravie\Codex\Exceptions\HttpException
     * @expectedExceptionMessage Server not available!
     */
    public function it_can_be_validate_server_errors()
    {
        $faker = Faker::create()
                    ->shouldResponseWith(500, '{"status":"ERROR","message":"Server not available!"}');

        $response = (new Response($faker->message()))->validate();
    }

    /**
     * @test
     * @expectedException \Laravie\Codex\Exceptions\HttpException
     * @expectedExceptionMessage I'm a teapot
     */
    public function it_can_be_validate_generic_errors()
    {
        $faker = Faker::create()
                    ->shouldResponseWith(418)
                    ->expectReasonPhraseIs("I'm a teapot");

        (new Response($faker->message()))->validate();
    }
}
