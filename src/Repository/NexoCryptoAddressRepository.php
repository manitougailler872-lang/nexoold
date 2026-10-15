<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\NexoCryptoAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NexoCryptoAddress>
 */
class NexoCryptoAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NexoCryptoAddress::class);
    }

    public function save(NexoCryptoAddress $nexoCryptoAddress, bool $flush = true): void
    {
        $this->getEntityManager()->persist($nexoCryptoAddress);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NexoCryptoAddress $nexoCryptoAddress, bool $flush = true): void
    {
        $this->getEntityManager()->remove($nexoCryptoAddress);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return NexoCryptoAddress[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
