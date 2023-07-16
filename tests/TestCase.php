<?php

namespace Tests;

use Astrotomic\VladhogSdk\VladhogConnector;
use Astrotomic\VladhogSdk\VladhogSdkServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Http\Faking\Fixture;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Laravel\Facades\Saloon;

abstract class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    protected VladhogConnector $vladhog;

    protected function setUp(): void
    {
        parent::setUp();

        Saloon::fake([
            VladhogConnector::class => function (PendingRequest $request): Fixture {
                $name = implode('/', array_filter([
                    parse_url($request->getUrl(), PHP_URL_HOST),
                    $request->getMethod()->value,
                    parse_url($request->getUrl(), PHP_URL_PATH),
                    http_build_query(array_diff_key($request->query()->all(), array_flip(['key', 'format']))),
                ]));

                return MockResponse::fixture($name);
            },
        ]);

        $this->vladhog = new VladhogConnector();
    }

    protected function getPackageProviders($app): array
    {
        return [
            VladhogSdkServiceProvider::class,
        ];
    }
}
