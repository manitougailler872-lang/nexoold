<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CryptoTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CryptoTypeRepository::class)]
#[ORM\Table(name: 'nexo_crypto_type')]
class CryptoType
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $tag;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $icon;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->createdAt = new \DateTimeImmutable();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

     public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): static
    {
        $this->tag = $tag;

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

    public function getCreatedAt():? \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
