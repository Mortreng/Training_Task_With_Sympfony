<?php

namespace App\Entity\Card;

class Card
{

    private string $pan;

    private CardVendors $cardVendor = CardVendors::Unknown;

    public function __constructor(string $pan, CardVendors $cardVendor): void {
        $this -> pan = $pan;
        $this -> cardVendor = $cardVendor;
    }

    /**
     * @return CardVendors
     */
    public function getCardVendor(): CardVendors
    {
        return $this->cardVendor;
    }

    /**
     * @return int
     */
    public function getPan(): int
    {
        return $this->pan;
    }

}

