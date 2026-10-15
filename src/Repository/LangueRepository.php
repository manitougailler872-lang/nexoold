<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Langue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Langue>
 */
class LangueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Langue::class);
    }

    public function save(Langue $langue, bool $flush = true): void
    {
        $this->getEntityManager()->persist($langue);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Langue $langue, bool $flush = true): void
    {
        $this->getEntityManager()->remove($langue);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Langue[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
