<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DonationTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass:DonationTypeRepository::class)]
#[ORM\Table(name: 'nexo_donation_type')]
class DonationType
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

}
