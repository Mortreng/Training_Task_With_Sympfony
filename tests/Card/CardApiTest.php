<?php

namespace App\Tests\Card;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;


class CardApiTest extends ApiTestCase
{
    /**
     * @test
     */
    public function gatherCardDataTest() {

        static::createClient()->request('POST', 'card/gather_card_data/4929703763028940');
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @test
     */
    public function gatherCardDataFailedTest() {

        static::createClient()->request('POST', 'card/gather_card_data/161243623461346');
        $this->assertResponseStatusCodeSame(500);
    }

    /**
     * @test
     */
    public function findCardTest(){
        static::createClient()->request('GET','api/card/find_card/1');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'pan'=>14873218937518, 'cardVendor'=>"daroni_credit"
        ]);
    }

}