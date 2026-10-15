<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CryptoType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CryptoType>
 */
class CryptoTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoType::class);
    }

    public function save(CryptoType $cryptoType, bool $flush = true): void
    {
        $this->getEntityManager()->persist($cryptoType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CryptoType $cryptoType, bool $flush = true): void
    {
        $this->getEntityManager()->remove($cryptoType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CryptoType[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
