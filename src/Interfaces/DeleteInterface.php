<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface DeleteInterface
{
    /**
     * @param  string  $url
     * @param  array  $headers
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function delete(
        string $url,
        array $headers = [],
    ): Collection;
}
