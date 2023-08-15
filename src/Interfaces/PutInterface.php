<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface PutInterface
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
    public function put(
        string $url,
        array $query = [],
        array $headers = [],
    ): Collection;
}
