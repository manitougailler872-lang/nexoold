<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Card>
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function save(Card $card, bool $flush = true): void
    {
        $this->getEntityManager()->persist($card);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Card $card, bool $flush = true): void
    {
        $this->getEntityManager()->remove($card);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Card[]
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
