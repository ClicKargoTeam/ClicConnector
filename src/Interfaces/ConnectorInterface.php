<?php

namespace ClicKargoTeam\ClicConnector\Interfaces;

use ClicKargoTeam\ClicConnector\MethodEnum;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

interface ConnectorInterface
{
    /**
     * @param  MethodEnum  $method
     * @param  string  $url
     * @param  array  $data
     * @param  array  $header
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function connect(
        MethodEnum $method,
        string $url,
        array $data = [],
        array $header = []
    ): Collection;

    /**
     * @param  PromiseInterface|Response  $response
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function response(PromiseInterface|Response $response): Collection;
}
