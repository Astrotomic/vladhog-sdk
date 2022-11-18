<?php

namespace Astrotomic\VladhogSdk\Requests;

use Astrotomic\VladhogSdk\Data\Ban;
use Carbon\CarbonImmutable;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;
use SteamID;

class GetBanInfoRequest extends SaloonRequest
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

        return "/info;steamid={$steamid};type=string";
    }

    protected function castToDto(SaloonResponse $response): ?Ban
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
