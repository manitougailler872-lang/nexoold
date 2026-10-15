<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CategoryExpenseCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryExpenseCustomer>
 */
class CategoryExpenseCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryExpenseCustomer::class);
    }
}
