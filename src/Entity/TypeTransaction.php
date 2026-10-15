<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TypeTransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TypeTransactionRepository::class)]
#[ORM\Table(name: 'nexo_type_transaction')]
class TypeTransaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $iconSvg = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $iconPng = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $iconCode = null;

    #[ORM\Column(type: 'boolean', nullable:true)]
    private ?bool $isIconCode = false;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $bgIconColor = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $textIconColor = null;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getIconSvg(): ?string
    {
        return $this->iconSvg;
    }

    public function setIconSvg(?string $iconSvg): static
    {
        $this->iconSvg = $iconSvg;

        return $this;
    }

    public function getIconPng(): ?string
    {
        return $this->iconPng;
    }

    public function setIconPng(?string $iconPng): static
    {
        $this->iconPng = $iconPng;

        return $this;
    }

    public function getIconCode(): ?string
    {
        return $this->iconCode;
    }

    public function setIconCode(?string $iconCode): static
    {
        $this->iconCode = $iconCode;

        return $this;
    }

    public function getIsIconCode(): ?bool
    {
        return $this->isIconCode;
    }

    public function setIsIconCode(?bool $isIconCode): static
    {
        $this->isIconCode = $isIconCode;

        return $this;
    }

    public function getBgIconColor(): ?string
    {
        return $this->bgIconColor;
    }

    public function setBgIconColor(?string $bgIconColor): static
    {
        $this->bgIconColor = $bgIconColor;

        return $this;
    }

    public function getTextIconColor(): ?string
    {
        return $this->textIconColor;
    }

    public function setTextIconColor(?string $textIconColor): static
    {
        $this->textIconColor = $textIconColor;

        return $this;
    }
}
