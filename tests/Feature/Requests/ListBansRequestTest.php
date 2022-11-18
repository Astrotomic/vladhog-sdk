<?php

use PHPUnit\Framework\Assert;

it('can load a list of banned steamids', function (): void {
    $bans = $this->vladhog->list();

    Assert::assertGreaterThan(0, $bans->count());
    Assert::assertContainsOnlyInstancesOf(SteamID::class, $bans);

    $bans->each(function (SteamID $steamid, string $original): void {
        Assert::assertSame($steamid->ConvertToUInt64(), (new SteamID($original))->ConvertToUInt64());
    });
});
