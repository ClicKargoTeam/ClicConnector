<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use ClicKargoTeam\ClicConnector\MethodEnum;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

trait PutTrait
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
    public function put(string $url, array $query = [], array $headers = []): Collection
    {
        return $this->connect(
            MethodEnum::PUT,
            $url,
            $query,
            $headers
        );
    }
}
