<?php

namespace ClicKargoTeam\ClicConnector\Traits;

use ClicKargoTeam\ClicConnector\MethodEnum;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

trait DeleteTrait
{
    /**
     * @param  string  $url
     * @param  array  $headers
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function delete(string $url, array $headers = []): Collection
    {
        return $this->connect(
            MethodEnum::DELETE,
            $url,
            [],
            $headers
        );
    }
}
