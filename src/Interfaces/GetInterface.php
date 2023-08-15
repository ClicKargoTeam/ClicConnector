<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface GetInterface
{
    /**
     * @param  string  $url
     * @param  array  $query
     * @param  array  $headers
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function get(
        string $url,
        array $query = [],
        array $headers = [],
    ): Collection;
}
