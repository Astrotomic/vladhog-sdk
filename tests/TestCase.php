<?php

namespace Tests;

use Astrotomic\VladhogSdk\VladhogConnector;
use Astrotomic\VladhogSdk\VladhogSdkServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Sammyjo20\Saloon\Http\Fixture;
use Sammyjo20\Saloon\Http\MockResponse;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\SaloonLaravel\Facades\Saloon;

abstract class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    protected VladhogConnector $vladhog;

    protected function setUp(): void
    {
        parent::setUp();

        Saloon::fake([
            VladhogConnector::class => function (SaloonRequest $request): Fixture {
                $name = implode('/', array_filter([
                    parse_url($request->getFullRequestUrl(), PHP_URL_HOST),
                    mb_strtoupper($request->getMethod() ?? 'GET'),
                    parse_url($request->getFullRequestUrl(), PHP_URL_PATH),
                    http_build_query(array_diff_key($request->getQuery(), array_flip(['key', 'format']))),
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
