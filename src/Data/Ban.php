<?php

namespace Astrotomic\VladhogSdk\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;
use SteamID;

final class Ban extends Data
{
    public function __construct(
        public readonly SteamID $steam_id,
        public readonly CarbonImmutable $banned_at,
        public readonly ?string $server,
        public readonly ?string $reason,
    ) {
    }
}
