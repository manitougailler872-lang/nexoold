<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\TypeTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeTransaction>
 */
class TypeTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTransaction::class);
    }

    public function save(TypeTransaction $typeTransaction, bool $flush = true): void
    {
        $this->getEntityManager()->persist($typeTransaction);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeTransaction $typeTransaction, bool $flush = true): void
    {
        $this->getEntityManager()->remove($typeTransaction);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TypeTransaction[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
