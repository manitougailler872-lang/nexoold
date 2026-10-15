<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SmsModelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass:SmsModel::class)]
#[ORM\Table(name: 'nexo_sms_model')]
class SmsModel
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

}
