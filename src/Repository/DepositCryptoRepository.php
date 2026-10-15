<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DepositCrypto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepositCrypto>
 */
class DepositCryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepositCrypto::class);
    }

    public function save(DepositCrypto $depositCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->persist($depositCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DepositCrypto $depositCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->remove($depositCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return DepositCrypto[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
