<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerCryptoAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerCryptoAddress>
 */
class CustomerCryptoAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerCryptoAddress::class);
    }

    public function save(CustomerCryptoAddress $customerCryptoAddress, bool $flush = true): void
    {
        $this->getEntityManager()->persist($customerCryptoAddress);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerCryptoAddress $customerCryptoAddress, bool $flush = true): void
    {
        $this->getEntityManager()->remove($customerCryptoAddress);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CustomerCryptoAddress[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
