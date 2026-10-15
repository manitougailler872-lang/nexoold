<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WithdrawCrypto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WithdrawCrypto>
 */
class WithdrawCryptoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WithdrawCrypto::class);
    }

    public function save(WithdrawCrypto $withdrawCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->persist($withdrawCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WithdrawCrypto $withdrawCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->remove($withdrawCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return WithdrawCrypto[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
