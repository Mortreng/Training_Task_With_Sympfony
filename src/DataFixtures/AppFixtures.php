<?php

namespace App\DataFixtures;

use App\Entity\BaseEntity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new DateTime();
        $now->format('Y-m-d H:i:s');
        $baseEntity = new BaseEntity();
        $baseEntity->setCreatedTime($now);

        $manager->persist($baseEntity);

        $manager->flush();
    }
}
