<?php

namespace App\Service;

use App\Entity\Card\CardVendors;
use ErrorException;

class CardService
{
    private function VerifyCardPan(string $pan): bool {
        $digits = strrev(preg_replace('/\D+/', '', $pan));
        $sum = 0;

        for ($i = 0, $j = strlen($digits); $i < $j; $i++) {
            if ($i % 2 == 0) {
                $val = $digits[$i];
            } else {
                $val = $digits[$i] * 2;
                if ($val > 9) {
                    $val -= 9;
                }
            }
            $sum += $val;
        }

        if (($sum % 10) == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function DetermineCardVendor(string $pan): CardVendors {

        // Magic numbers, need to somehow get those values from the config.
        $cardPrefixes = [
            'Visa'=> ['4'],
            'Maestro' => array_merge(['50','56','58','57'], range('60', '69')),
            'Daroni' => ['14','81','99'],
            'MasterCard' => ['TwoPrefixInn' => range('51', '55'), 'FourPrefixInn'=> range('2221', '2720')]
        ];

        switch ($pan) {
            case in_array(substr($pan, 0,1), $cardPrefixes['Visa']) && in_array(strlen($pan), [13, 16]):
                return CardVendors::Visa;
            case in_array(substr($pan, 0, 2), $cardPrefixes['Daroni'] ) && strlen($pan) == 14:
                return CardVendors::DaroniCredit;
            case in_array(substr($pan,0, 2), $cardPrefixes['MasterCard']['TwoPrefixInn']) || in_array(substr($pan,0, 6), $cardPrefixes['MasterCard']['FourPrefixInn']) && strlen($pan) == 16:
                return CardVendors::MasterCard;
            case in_array(substr($pan, 0, 2), $cardPrefixes['Maestro']) && in_array(strlen($pan), range(12, 19)):
                return CardVendors::Maestro;
            default:
                return CardVendors::Unknown;
        }
    }

    //This code reeks need to do something actually decent
    /**
     * @throws ErrorException
     */
    public function GatherCardData(string $pan): string {
        if ($this->VerifyCardPan($pan)) {
            $vendor = $this->DetermineCardVendor($pan);
            if ($vendor != CardVendors::Unknown) {
                //$card = new Card($pan, $vendor);
                return "It worked, here is your vendor: $vendor->name";
            } else {
                throw new ErrorException("Unknown card vendor, we support Visa, Master Card, Maestro, Daroni Credit" . PHP_EOL);
            }
        } else {
            throw new ErrorException("$pan didn't pass the Luhm algorithm" . PHP_EOL);
        }
    }
}