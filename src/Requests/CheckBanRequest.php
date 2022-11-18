<?php

namespace Astrotomic\VladhogSdk\Requests;

use Illuminate\Support\Str;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;
use SteamID;

class CheckBanRequest extends SaloonRequest
{
    use CastsToDto;

    protected ?string $method = 'GET';

    public function __construct(
        public readonly string|SteamID $steamid,
    ) {
    }

    public function defineEndpoint(): string
    {
        $steamid = is_string($this->steamid)
            ? $this->steamid
            : $this->steamid->RenderSteam2();

        return "/get;steamid={$steamid};type=string";
    }

    protected function castToDto(SaloonResponse $response): bool
    {
        return (bool) json_decode(Str::lower($response->body()));
    }
}
