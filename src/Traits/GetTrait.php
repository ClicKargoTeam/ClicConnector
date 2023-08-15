<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use ClicKargoTeam\ClicConnector\MethodEnum;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

trait GetTrait
{
    public bool $shouldCache = false;

    /**
     * @param  string  $url
     * @param  array  $query
     * @param  array  $headers
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function get(string $url, array $query = [], array $headers = []): Collection
    {
        return $this->connect(
            MethodEnum::GET,
            $url,
            $query,
            $headers
        );
    }
}
