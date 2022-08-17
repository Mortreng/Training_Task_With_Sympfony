<?php

namespace App\Service;

class CardService
{
    public function VerifyAndCollectCardData(string $Pan): bool {

        $cardPrefixes = [
            'Visa'=> ['4'],
            'Maestro' => array_merge(['50','56','58','57'], range('60', '69')),
            'Daroni' => ['14','81','99'],
            'MasterCard' => ['TwoPrefixInn' => range('51', '55'), 'SixPrefixInn'=> range('2221', '2720')]];
        $digits = strrev(preg_replace('/\D+/', '', $Pan));
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
        echo "the sum of all digits equals $sum" . PHP_EOL;

        if (($sum % 10) == 0) {
            switch ($Pan) {
                case in_array(substr($Pan, 0,1), $cardPrefixes['Visa']) && in_array(strlen($Pan), [13, 16]):
                    //$card = new Card(CardVendors::Visa, $randomPan);
                    echo 'This is a Visa Card' . PHP_EOL;
                    return true;
                case in_array(substr($Pan, 0, 2), $cardPrefixes['Daroni'] ) && strlen($Pan) == 14:
                    //$card = new Card(CardVendors::DaroniCredit, $randomPan);
                    echo 'This is a Daroni Credit Card' . PHP_EOL;
                    return true;
                case in_array(substr($Pan,0, 2), $cardPrefixes['MasterCard']['TwoPrefixInn']) || in_array(substr($Pan,0, 6), $cardPrefixes['MasterCard']['SixPrefixInn']) && strlen($Pan) == 16:
                    //$card = new Card(CardVendors::MasterCard, $randomPan);
                    echo 'This is a MasterCard Credit Card' . PHP_EOL;
                    return true;
                case in_array(substr($Pan, 0, 2), $cardPrefixes['Maestro']) && in_array(strlen($Pan), range(12, 19)):
                    //$card = new Card(CardVendors::Maestro, $randomPan);
                    echo 'This is a Maestro Card' . PHP_EOL;
                    return true;
                default:
                    echo "the number entered doesn't match with any of the card vendors, try another";
                    return false;
            }
        } else {
            echo "$Pan didn't pass the Luhm algorithm" . PHP_EOL;
            return false;
        }
    }
}