<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface PostInterface
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
    public function post(
        string $url,
        array $body = [],
        array $headers = [],
    ): Collection;
}
