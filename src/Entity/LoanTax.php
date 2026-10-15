<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LoanTaxRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LoanTaxRepository::class)]
#[ORM\Table(name: 'nexo_loan_tax')]
class LoanTax
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;


}
