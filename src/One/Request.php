<?php

namespace Etiqa\MotorInsurance\One;

use Etiqa\MotorInsurance\Request as BaseRequest;

abstract class Request extends BaseRequest
{
    /**
     * Version namespace.
     *
     * @var string
     */
    protected $version = 'v1.0';
}
