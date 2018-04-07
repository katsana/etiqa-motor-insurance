<?php

namespace Etiqa\MotorInsurance\One;

use Laravie\Codex\Contracts\Response;

class Policy extends Request
{
    /**
     * Send quotation request.
     *
     * @param array $payload
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function submit(array $payload): Response
    {
        return $this->sendJson('POST', 'motor/policy', $this->getApiHeaders(), $this->mergeApiBody($payload));
    }
}
