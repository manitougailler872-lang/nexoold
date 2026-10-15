<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryExpenseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryExpenseRepository::class)]
#[ORM\Table(name: 'nexo_category_expense')]
class CategoryExpense
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $tag;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $color;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

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
}
