<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DonationApplyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DonationApplyRepository::class)]
#[ORM\Table(name: 'nexo_donation_apply')]
class DonationApply
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

}
