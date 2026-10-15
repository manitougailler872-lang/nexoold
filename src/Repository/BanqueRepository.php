<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Banque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Banque>
 */
class BanqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banque::class);
    }

    public function save(Banque $banque, bool $flush = true): void
    {
        $this->getEntityManager()->persist($banque);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Banque $banque, bool $flush = true): void
    {
        $this->getEntityManager()->remove($banque);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Banque[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
