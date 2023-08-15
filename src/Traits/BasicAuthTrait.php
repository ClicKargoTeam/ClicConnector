<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use Illuminate\Http\Client\PendingRequest;

trait BasicAuthTrait
{
    public string $username;
    public string $password;

    /**
     * @param  PendingRequest  $connector
     *
     * @return PendingRequest
     */
    public function prepareForAuthentication(PendingRequest $connector): PendingRequest
    {
        $connector->withBasicAuth(
            username: $this->username,
            password: $this->password
        );

        return $connector;
    }
}
