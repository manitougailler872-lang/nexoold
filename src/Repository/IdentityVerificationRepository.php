<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\IdentityVerification;
use App\Enum\VerificationStatus;
use App\Enum\VerificationStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IdentityVerification>
 */
class IdentityVerificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdentityVerification::class);
    }

    /**
     * File d'attente de vérification pour le back-office.
     *
     * @return IdentityVerification[]
     */
    public function findPendingReview(): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.status = :status')
            ->setParameter('status', VerificationStatusEnum::SUBMITTED)
            ->orderBy('v.submittedAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(IdentityVerification $verification, bool $flush = true): void
    {
        $this->getEntityManager()->persist($verification);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
