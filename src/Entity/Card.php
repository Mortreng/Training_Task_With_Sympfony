<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\FindCardObj;
use App\Controller\GatherCardData;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    collectionOperations: ['post'=> [
        'path'=>'/card/gather_card_data/{pan}',
        'normalization_context'=>['groups' => 'GatherCardData'],
        'controller'=>GatherCardData::class
    ]],
    itemOperations: ['get'=>[
        'path'=>'/card/find_card/{id}',
        'normalization_context'=>[
            'groups' => 'FindCardObj'],
        'controller'=>FindCardObj::class
        ]
    ],
    order: ['createdTime' => 'DESC']
)]
class Card extends BaseEntity
{

    #[ORM\Column(type:'string')]
    #[Groups(['FindCardObj', 'GatherCardData'])]
    private string $pan;

    #[ORM\Column(type:'string',enumType: CardVendors::class)]
    #[Groups(['FindCardObj', 'GatherCardData'])]
    #[ApiProperty(
        attributes: [
            'openapi_context' => [
                'type' => 'string',
                'enum' => ['daroni_credit', 'visa', 'master_card', 'maestro'],
                'example' => 'visa',
            ],
        ],
    )]
    private CardVendors $cardVendor = CardVendors::Unknown;

    public function __construct(string $pan, CardVendors $cardVendor) {
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

