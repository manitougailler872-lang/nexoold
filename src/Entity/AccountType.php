<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccountTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AccountTypeRepository::class)]
#[ORM\Table(name: 'nexo_account_type')]
class AccountType
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 100, nullable:true)]
    private ?string $label;

    #[ORM\Column(type: 'text', nullable:true)]
    private ?string $description;

    #[ORM\Column(type: 'text', nullable:true)]
    private ?string $advantages;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable:true)]
    private ?string $plafond;

    #[ORM\Column(type: 'string', length: 50, nullable:true)]
    private ?string $tag;
    
    #[ORM\Column(type: 'string', length:50, nullable:true)]
    private ?string $devise;

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

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdvantages(): ?string
    {
        return $this->advantages;
    }

    public function setAdvantages(?string $advantages): static
    {
        $this->advantages = $advantages;

        return $this;
    }

    public function getPlafond(): ?string
    {
        return $this->plafond;
    }

    public function setPlafond(?string $plafond): static
    {
        $this->plafond = $plafond;

        return $this;
    }

      public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(?string $devise): static
    {
        $this->devise = $devise;

        return $this;
    }
}
