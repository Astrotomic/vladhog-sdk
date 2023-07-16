<?php

namespace Astrotomic\VladhogSdk\Requests;

use Illuminate\Support\Collection;
use Saloon\Contracts\Response as ResponseContract;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\CastDtoFromResponse;
use SteamID;

class ListBansRequest extends Request
{
    use CastDtoFromResponse;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/get_list';
    }

    /**
     * @return Collection<string, \SteamID>
     */
    public function createDtoFromResponse(ResponseContract $response): Collection
    {
        return $response->collect()
            ->mapWithKeys(fn (string $steamid) => [
                $steamid => rescue(fn () => new SteamID($steamid), report: false),
            ])
            ->filter();
    }
}
