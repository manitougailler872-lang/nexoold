<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LoanTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LoanTypeRepository::class)]
#[ORM\Table(name: 'nexo_loan_type')]
class LoanType
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

}
