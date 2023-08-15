<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use Illuminate\Http\Client\PendingRequest;

interface AuthenticationInterface
{
    /**
     * @param  PendingRequest  $connector
     *
     * @return PendingRequest
     */
    public function prepareForAuthentication(PendingRequest $connector): PendingRequest;
}
