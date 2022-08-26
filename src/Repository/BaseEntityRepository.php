<?php

namespace App\Repository;

use App\Entity\BaseEntity;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class BaseEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BaseEntity::class);
    }

    public function setEntity(BaseEntity $baseEntity): mixed {

        $entityManager = $this->getEntityManager();

        $now = new DateTime();
        $now->format('Y-m-d H:i:s');
        $baseEntity->createdTime = $now;
        $entityManager->persist($baseEntity);
        $entityManager->flush();
        return $baseEntity->getId();
    }


    public function findEntity(int $id): ?BaseEntity {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}