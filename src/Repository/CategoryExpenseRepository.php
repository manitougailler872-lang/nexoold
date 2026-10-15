<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CategoryExpense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryExpense>
 */
class CategoryExpenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryExpense::class);
    }

    public function save(CategoryExpense $categoryExpense, bool $flush = true): void
    {
        $this->getEntityManager()->persist($categoryExpense);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryExpense $categoryExpense, bool $flush = true): void
    {
        $this->getEntityManager()->remove($categoryExpense);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CategoryExpense[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
