<?php

namespace Etiqa\MotorInsurance\TestCase\Exceptions;

use Etiqa\MotorInsurance\Exceptions\RequestHasFailedException;
use Laravie\Codex\Contracts\Response;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class RequestHasFailedExceptionTest extends TestCase
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
        $response = m::mock(Response::class);
        $response->shouldReceive('getStatusCode')->andReturn(200);

        $stub = new RequestHasFailedException($response, 'Driver record incomplete. Please provide details', 'A038');

        $this->assertSame('A038', $stub->getResponseErrorCode());
    }
}
