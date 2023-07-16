<?php

namespace Astrotomic\VladhogSdk\Requests;

use Illuminate\Support\Str;
use Saloon\Contracts\Response as ResponseContract;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\CastDtoFromResponse;
use SteamID;

class CheckBanRequest extends Request
{
    use CastDtoFromResponse;

    protected Method $method = Method::GET;

    public function __construct(
        public readonly string|SteamID $steamid,
    ) {
    }

    public function resolveEndpoint(): string
    {
        $steamid = is_string($this->steamid)
            ? $this->steamid
            : $this->steamid->RenderSteam2();

        return "/get;steamid={$steamid};type=string";
    }

    public function createDtoFromResponse(ResponseContract $response): bool
    {
        return (bool) json_decode(Str::lower($response->body()), true, 512, JSON_THROW_ON_ERROR);
    }
}
