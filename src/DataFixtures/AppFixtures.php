<?php

namespace App\DataFixtures;

use App\Entity\BaseEntity;
use App\Entity\Card;
use App\Entity\CardVendors;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new DateTime();
        $now->format('Y-m-d H:i:s');
        $card = new Card("14873218937518", CardVendors::DaroniCredit);
        $card->setCreatedTime($now);

        $manager->persist($card);

        $manager->flush();
    }
}
