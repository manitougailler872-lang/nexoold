<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EmailModelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass:EmailModelRepository::class)]
#[ORM\Table(name: 'nexo_email_model')]
class EmailModel
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

}
