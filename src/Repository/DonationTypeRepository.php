<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DonationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DonationType>
 */
class DonationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonationType::class);
    }
}
