<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use Illuminate\Http\Client\PendingRequest;

trait ApiTokenTrait
{
    public string $token;
    public string $token_type = 'Bearer';

    /**
     * @param  PendingRequest  $connector
     *
     * @return PendingRequest
     */
    public function prepareForAuthentication(PendingRequest $connector): PendingRequest
    {
        $connector->withToken(
            token: $this->token,
            type: $this->token_type
        );

        return $connector;
    }
}
