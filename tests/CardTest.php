<?php
namespace App\Tests;

use App\Service\CardService;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase {

    /**
     * @dataProvider PositivePanProvider
     * @test
     */

    public function TestCardValidationPositive($pan) {

        $cardService = new CardService();
        $verificationResult = $cardService-> VerifyAndCollectCardData($pan);

        $this-> assertTrue($verificationResult);
    }

    public function PositivePanProvider(): array {
        return [
            ["4929703763028940"], // Visa
            ["14873218937518"], // Daroni Credit
            ["5107578487195683"], //MasterCard
            ["5027617984072966"], //Maestro
        ];
    }

    /**
     * @test
     * @dataProvider negativePanProvider
     */

    public function TestCardValidationNegative($pan) {

        $cardService = new CardService();
        $verificationResult = $cardService-> VerifyAndCollectCardData($pan);

        $this-> assertFalse($verificationResult);
    }


    public function negativePanProvider(): array {
        return [
            ["152412312399124"], //Number that doesn't pass the luhm algorithm
            ["4824759102748359"], //Doesn't pass the luhm algorithm, has a visa prefix and exact length of a visa card
            ["2665294464"] //Passes the luhm algorithm, fails the card vendor switch
        ];
    }

}
