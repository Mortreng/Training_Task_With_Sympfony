<?php

namespace App\Tests;

use App\Entity\BaseEntity;
use App\Entity\Card;
use App\Entity\CardVendors;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseEntityRepositoryTest extends KernelTestCase
{

    private ?EntityManager $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function SetEntityTest() {
        $entityManager = $this->entityManager;
        $id = $entityManager
            ->getRepository(BaseEntity::class)
            ->setEntity(new BaseEntity());

        $entity = $entityManager
            ->getRepository(BaseEntity::class)
            ->findEntity($id);
        self::assertNotNull($entity);

    }

    /**
     * @test
     */
    public function SetCardTest() {
        $entityManager = $this->entityManager;
        $id = $entityManager
            ->getRepository(BaseEntity::class)
            ->setEntity(new Card("12412312314", CardVendors::Visa ));

        $entity = $entityManager
            ->getRepository(BaseEntity::class)
            ->find($id);

        if ($entity instanceof Card) {
            $pan = $entity->getPan();
            $this->assertEquals("12412312314", $pan);
        } else {
            $this->fail("$entity is not of the instance Card");
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}