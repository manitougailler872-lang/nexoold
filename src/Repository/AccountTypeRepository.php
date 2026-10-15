<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccountType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountType>
 */
class AccountTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountType::class);
    }

    public function save(AccountType $compteType, bool $flush = true): void
    {
        $this->getEntityManager()->persist($compteType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountType $compteType, bool $flush = true): void
    {
        $this->getEntityManager()->remove($compteType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return AccountType[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
