<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DeviseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DeviseRepository::class)]
#[ORM\Table(name: 'nexo_devise')]
class Devise
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $countryIso;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $codeIso;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $symbol;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'devise')]
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

     public function getCountryIso(): ?string
    {
        return $this->countryIso;
    }

    public function setCountryIso(?string $countryIso): static
    {
        $this->countryIso = $countryIso;

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

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): static
    {
        $this->symbol = $symbol;

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
