<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LangueRepository::class)]
#[ORM\Table(name: 'nexo_langue')]
class Langue
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $codeIso;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'language')]
    private Collection $users;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCodeIso(): ?string
    {
        return $this->codeIso;
    }

    public function setCodeIso(?string $codeIso): static
    {
        $this->codeIso = $codeIso;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }
    public function getUsers(): \Doctrine\Common\Collections\Collection { return $this->users; }
}
