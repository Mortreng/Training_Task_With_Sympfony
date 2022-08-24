<?php

namespace App\Entity;

use App\Repository\BaseEntityRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;

#[ORM\Entity(repositoryClass: BaseEntityRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['base_entity'=> 'BaseEntity','card' => "Card"])]

class BaseEntity
{
    #[ORM\Column(type:'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    public int $id;

    #[ORM\Column(type: 'datetime')]
    public DateTime $createdTime;


    /**
     * @param mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param DateTime $createdTime
     */
    public function setCreatedTime(DateTime $createdTime): void {
        $this->createdTime = $createdTime;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedTime(): ?DateTime {
        return $this->createdTime;
    }

}