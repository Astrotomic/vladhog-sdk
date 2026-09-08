<?php

namespace Tests\Feature\Requests;

use Astrotomic\VladhogSdk\Data\Ban;
use SteamID;
use Tests\TestCase;

final class GetBanInfoRequestTest extends TestCase
{
    public function test_can_get_ban_info_by_a_string_steamid(): void
    {
        foreach ($this->steamIds() as $steamid) {
            $ban = $this->vladhog->info($steamid);

            $this->assertInstanceOf(Ban::class, $ban);
            $this->assertSame($ban->steam_id->ConvertToUInt64(), (new SteamID($steamid))->ConvertToUInt64());
        }
    }

    /**
     * @return list<string>
     */
    private function steamIds(): array
    {
        return [
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
        ];
    }
}
