<?php

namespace Astrotomic\VladhogSdk;

use Illuminate\Support\ServiceProvider;

class VladhogSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(VladhogConnector::class);
    }
}
