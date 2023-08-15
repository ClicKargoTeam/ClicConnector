<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use ClicKargoTeam\ClicConnector\MethodEnum;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

trait PostTrait
{
    /**
     * @param  string  $url
     * @param  array  $body
     * @param  array  $headers
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function post(string $url, array $body = [], array $headers = []): Collection
    {
        return $this->connect(
            MethodEnum::POST,
            $url,
            $body,
            $headers
        );
    }
}
