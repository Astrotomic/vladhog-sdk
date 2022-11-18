<?php

namespace Astrotomic\VladhogSdk;

use Astrotomic\VladhogSdk\Data\Ban;
use Astrotomic\VladhogSdk\Requests\CheckBanRequest;
use Astrotomic\VladhogSdk\Requests\GetBanInfoRequest;
use Astrotomic\VladhogSdk\Requests\ListBansRequest;
use Astrotomic\VladhogSdk\Responses\VladhogResponse;
use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AlwaysThrowsOnErrors;
use SteamID;

class VladhogConnector extends SaloonConnector
{
    use AlwaysThrowsOnErrors;

    protected ?string $response = VladhogResponse::class;

    public function defineBaseUrl(): string
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
