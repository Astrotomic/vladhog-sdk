<?php

namespace Astrotomic\VladhogSdk\Requests;

use Illuminate\Support\Collection;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;
use SteamID;

class ListBansRequest extends SaloonRequest
{
    use CastsToDto;

    protected ?string $method = 'GET';

    public function defineEndpoint(): string
    {
        return '/get_list';
    }

    /**
     * @param  \Sammyjo20\Saloon\Http\SaloonResponse  $response
     * @return \Illuminate\Support\Collection<string, \SteamID>
     */
    protected function castToDto(SaloonResponse $response): Collection
    {
        return $response->collect()
            ->mapWithKeys(fn (string $steamid) => [
                $steamid => rescue(fn () => new SteamID($steamid), report: false),
            ])
            ->filter();
    }
}
