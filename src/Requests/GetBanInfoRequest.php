<?php

namespace Astrotomic\VladhogSdk\Requests;

use Astrotomic\VladhogSdk\Data\Ban;
use Carbon\CarbonImmutable;
use Saloon\Contracts\Response as ResponseContract;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\CastDtoFromResponse;
use SteamID;

class GetBanInfoRequest extends Request
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

        return "/info;steamid={$steamid};type=string";
    }

    public function createDtoFromResponse(ResponseContract $response): ?Ban
    {
        if (str_starts_with($response->body(), 'Error: ')) {
            return null;
        }

        [$server, $reason, $date] = explode(',', $response->body(), 3);

        return new Ban(
            steam_id: is_string($this->steamid)
                ? new SteamID($this->steamid)
                : $this->steamid,
            banned_at: CarbonImmutable::parse(trim($date)),
            server: $server,
            reason: $reason,
        );
    }
}
