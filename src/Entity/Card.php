<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Card extends BaseEntity
{

    #[ORM\Column(type:'string')]
    private string $pan;

    #[ORM\Column(type:'string',enumType: CardVendors::class)]
    private CardVendors $cardVendor = CardVendors::Unknown;

    public function __constructor(mixed $id, DateTime $createdTime, string $pan, CardVendors $cardVendor): void {
        $this -> id = $id;
        $this -> createdTime = $createdTime;
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
     * @param CardVendors $cardVendor
     */
    public function setCardVendor(CardVendors $cardVendor) {
        $this->cardVendor = $cardVendor;
    }

    /**
     * @return int
     */
    public function getPan(): int
    {
        return $this->pan;
    }

    /**
     * @param string $pan
     */
    public function setPan(string $pan) {
        $this->pan = $pan;
    }
}

