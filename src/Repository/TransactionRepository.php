<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function save(Transaction $transaction, bool $flush = true): void
    {
        $this->getEntityManager()->persist($transaction);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Transaction $transaction, bool $flush = true): void
    {
        $this->getEntityManager()->remove($transaction);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Transaction[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
