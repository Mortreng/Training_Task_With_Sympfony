<?php
namespace App\Tests\Card;

use App\Service\CardService;
use ErrorException;
use PHPUnit\Framework\TestCase;

class CardServiceTest extends TestCase {

    /**
     * @test
     * @dataProvider PositivePanProvider
     */
    public function TestGatherCardDataPositive($pan) {

        $baseEntityRepo = $this->getMockBuilder('App\Repository\BaseEntityRepository')
            ->disableOriginalConstructor()
            ->getMock();


        $cardService = new CardService($baseEntityRepo);

        $verificationResult = $cardService->GatherCardData($pan);

        $this-> assertNotEmpty($verificationResult);
        print_r($verificationResult . PHP_EOL);
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

    public function TestGatherCardDataNegative($pan) {

        $baseEntityRepo = $this->getMockBuilder('App\Repository\BaseEntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $cardService = new CardService($baseEntityRepo);

        $this-> expectException(ErrorException::class);
        $cardService->GatherCardData($pan);
    }


    public function negativePanProvider(): array {
        return [
            ["152412312399124"], //Doesn't pass the luhm algorithm
            ["4824759102748359"], //Doesn't pass the luhm algorithm, has a visa prefix and an exact length of a visa card
            ["2665294464"] //Passes the luhm algorithm, fails the card vendor switch statement
        ];
    }

}
