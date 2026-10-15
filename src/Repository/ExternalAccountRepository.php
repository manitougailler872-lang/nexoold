<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExternalAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExternalAccount>
 */
class ExternalAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalAccount::class);
    }

    public function save(ExternalAccount $depositCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->persist($depositCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExternalAccount $depositCrypto, bool $flush = true): void
    {
        $this->getEntityManager()->remove($depositCrypto);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ExternalAccount[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
