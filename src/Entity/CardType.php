<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Devise;
use App\Repository\CardTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CardTypeRepository::class)]
#[ORM\Table(name: 'nexo_card_type')]
class CardType
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'text', nullable:true)]
    private ?string $advantages;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $tag;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $currencyIso;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?string $amount;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?string $spendByMonth = '0.00';

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?string $spendByDay = '0.00';

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;

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

    public function getDevise(): ?string
    {
        return $this->currencyIso;
    }

    public function setDevise(?string $currencyIso): static
    {
        $this->currencyIso = $currencyIso;

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

    
    public function getSpendByMonth(): ?string
    {
        return $this->spendByMonth;
    }

    public function setSpendByMonth(?string $spendByMonth): static
    {
        $this->spendByMonth = $spendByMonth;

        return $this;
    }

    public function getSpendByDay(): ?string
    {
        return $this->spendByDay;
    }

    public function setSpendByDay(?string $spendByDay): static
    {
        $this->spendByDay = $spendByDay;

        return $this;
    }

}
