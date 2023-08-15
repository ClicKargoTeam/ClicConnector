<?php

namespace ClicKargoTeam\ClicConnector\Abstracts;

use ClicKargoTeam\ClicConnector\Interfaces\ConnectorInterface;
use ClicKargoTeam\ClicConnector\MethodEnum;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class AbstractConnector implements ConnectorInterface
{
    public string $baseUrl;

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
    public function connect(MethodEnum $method, string $url, array $data = [], array $header = []): Collection
    {
        $connector = Http::withHeaders($header)
            ->baseUrl($this->baseUrl)
            ->withOptions([
                'debug' => (bool) config('clicconnect.debug'),
                'verify' => false,
                'timeout' => 30,
            ]);

        $connector = $this->prepareForAuthentication($connector)->dump();

        /** @var PromiseInterface|Response $response */
        $response = match ($method) {
            MethodEnum::GET => $connector->get($url, $data),
            MethodEnum::POST => $connector->post($url, $data),
            MethodEnum::PUT => $connector->put($url, $data),
            MethodEnum::DELETE => $connector->delete($url, $data),
            default => throw new RuntimeException('Method not found'),
        };

        return $this->response($response);
    }

    /**
     * @param  PromiseInterface|Response  $response
     *
     * @throws RequestException
     *
     * @return Collection
     */
    public function response(PromiseInterface|Response $response): Collection
    {
        $responseBody = $response->collect();
        if (!$response->ok() || $response->clientError()) {
            if ($responseBody->has('message')) {
                throw new RuntimeException($responseBody->get('message'));
            }

            $response->throw();
        }

        return $responseBody;
    }

    /**
     * @param  PendingRequest  $connector
     *
     * @return PendingRequest
     */
    public function prepareForAuthentication(PendingRequest $connector): PendingRequest
    {
        return $connector;
    }
}
