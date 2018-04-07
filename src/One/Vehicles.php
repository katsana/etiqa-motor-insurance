<?php

namespace Etiqa\MotorInsurance\One;

use Laravie\Codex\Contracts\Response;

class Vehicles extends Request
{
    /**
     * Get all whitelist vehicles.
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function all(): Response
    {
        return $this->sendJson('GET', 'motor/vehicles', $this->getApiHeaders());
    }

    /**
     * Get all whitelist vehicles by make.
     *
     * @param int $id
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function make($id): Response
    {
        return $this->sendJson('GET', "motor/vehicles/{$id}", $this->getApiHeaders());
    }

    /**
     * Get all whitelist vehicles by make, model and year.
     *
     * @param string $make
     * @param string $model
     * @param int    $year
     *
     * @return \Laravie\Codex\Contracts\Response
     */
    public function show($make, $model, $year): Response
    {
        return $this->sendJson('GET', "motor/vehicles/{$make}/{$model}/{$year}", $this->getApiHeaders());
    }
}
