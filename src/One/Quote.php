<?php

namespace Etiqa\MotorInsurance\One;

use Laravie\Codex\Contracts\Response;

class Quote extends Request
{
    /**
     * Create quick draft quotation request.
     *
     * @param array $payload
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function draft(array $payload): Response
    {
        $payload['quick_quote'] = true;

        return $this->submit($payload);
    }

    /**
     * Send quotation request.
     *
     * @param array $payload
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function submit(array $payload): Response
    {
        return $this->sendJson('POST', 'motor/quote', $this->getApiHeaders(), $this->mergeApiBody($payload));
    }
}
