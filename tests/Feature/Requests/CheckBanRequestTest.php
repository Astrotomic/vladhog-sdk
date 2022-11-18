<?php

use PHPUnit\Framework\Assert;

it('can check if a string steamid is banned', function (string $steamid): void {
    $banned = $this->vladhog->check($steamid);

    Assert::assertTrue($banned);
})->with([
    'STEAM_0:0:150035229',
    'STEAM_0:1:419450977',
    'STEAM_0:1:127526733',
    'STEAM_0:0:606525190',
    'STEAM_0:1:599634661',
    'STEAM_0:1:196203597',
    'STEAM_0:0:589952657',
    'STEAM_0:1:587485375',
    'STEAM_1:1:111633912',
    'STEAM_1:0:163327761',
    'STEAM_1:1:126572801',
    'STEAM_1:0:189655069',
]);

it('can check if a object steamid is banned', function (string $steamid): void {
    $banned = $this->vladhog->check(new SteamID($steamid));

    Assert::assertIsBool($banned);
})->with([
    'STEAM_0:0:150035229',
    'STEAM_0:1:419450977',
    'STEAM_0:1:127526733',
    'STEAM_0:0:606525190',
    'STEAM_0:1:599634661',
    'STEAM_0:1:196203597',
    'STEAM_0:0:589952657',
    'STEAM_0:1:587485375',
    'STEAM_1:1:111633912',
    'STEAM_1:0:163327761',
    'STEAM_1:1:126572801',
    'STEAM_1:0:189655069',
]);
