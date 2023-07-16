<?php

namespace Astrotomic\VladhogSdk;

use Astrotomic\VladhogSdk\Data\Ban;
use Astrotomic\VladhogSdk\Requests\CheckBanRequest;
use Astrotomic\VladhogSdk\Requests\GetBanInfoRequest;
use Astrotomic\VladhogSdk\Requests\ListBansRequest;
use Astrotomic\VladhogSdk\Responses\VladhogResponse;
use Illuminate\Support\Collection;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use SteamID;

class VladhogConnector extends Connector
{
    use AlwaysThrowOnErrors;

    protected ?string $response = VladhogResponse::class;

    public function resolveBaseUrl(): string
    {
        return 'https://vladhog.ru/GlobalBanListAPI/api';
    }

    /**
     * @return \Illuminate\Support\Collection<string, \SteamID>
     */
    public function list(): Collection
    {
        return $this->send(
            new ListBansRequest()
        )->dto();
    }

    public function check(string|SteamID $steamid): bool
    {
        return $this->send(
            new CheckBanRequest($steamid)
        )->dto();
    }

    public function info(string|SteamID $steamid): ?Ban
    {
        return $this->send(
            new GetBanInfoRequest($steamid)
        )->dto();
    }
}
