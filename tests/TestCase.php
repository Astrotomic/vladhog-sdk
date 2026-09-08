<?php

namespace Tests;

use Astrotomic\VladhogSdk\VladhogConnector;
use Astrotomic\VladhogSdk\VladhogSdkServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RuntimeException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

abstract class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    protected VladhogConnector $vladhog;

    protected function setUp(): void
    {
        parent::setUp();

        MockClient::destroyGlobal();
        MockClient::global([
            VladhogConnector::class => function (PendingRequest $request): MockResponse {
                $name = implode('/', array_filter([
                    parse_url($request->getUrl(), PHP_URL_HOST),
                    $request->getMethod()->value,
                    parse_url($request->getUrl(), PHP_URL_PATH),
                    http_build_query(array_diff_key($request->query()->all(), array_flip(['key', 'format']))),
                ]));

                $path = __DIR__."/Fixtures/Saloon/{$name}.json";
                $contents = file_get_contents($path);

                if ($contents === false) {
                    throw new RuntimeException("Unable to read Saloon fixture [{$path}].");
                }

                $fixture = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

                return MockResponse::make(
                    body: $fixture['data'],
                    status: $fixture['statusCode'],
                    headers: $fixture['headers'],
                );
            },
        ]);

        $this->vladhog = new VladhogConnector;
    }

    protected function tearDown(): void
    {
        MockClient::destroyGlobal();

        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            VladhogSdkServiceProvider::class,
        ];
    }
}
