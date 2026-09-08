<?php

namespace Tests\Feature\Requests;

use SteamID;
use Tests\TestCase;

final class ListBansRequestTest extends TestCase
{
    public function test_can_load_a_list_of_banned_steamids(): void
    {
        $bans = $this->vladhog->list();

        $this->assertGreaterThan(0, $bans->count());
        $this->assertContainsOnlyInstancesOf(SteamID::class, $bans);

        $bans->each(function (SteamID $steamid, string $original): void {
            $this->assertSame($steamid->ConvertToUInt64(), (new SteamID($original))->ConvertToUInt64());
        });
    }
}
