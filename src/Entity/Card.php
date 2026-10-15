<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\CardType;
use App\Entity\Customer;
use App\Entity\Devise;
use App\Enum\CardStatusEnum;
use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CardRepository::class)]
#[ORM\Table(name: 'nexo_card')]
class Card
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length:255, nullable: true)]
    private ?string $label;
    
    #[ORM\Column(type: 'string', length:255, nullable: true)]
    private ?string $subLabel;

    #[ORM\Column(type: 'decimal',precision:14, scale:2,  nullable: true)]
    private ?string $percentUsed;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'cards')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    #[ORM\ManyToOne(targetEntity: CardType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CardType $cardType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cardNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cardNumberMask;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2, nullable: true)]
    private ?string $amount;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $expireMonth;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $expire;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $variante;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $expireYear;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $isPrincipal;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $gaugeColor;

    #[ORM\Column(type: 'decimal', precision:14,scale:2, nullable:true)]
    private ?string $amountExpendedThisMonthly;

    #[ORM\Column(type: 'string', length: 4, nullable: true)]
    private ?string $cvv;

    #[ORM\ManyToOne(targetEntity: Devise::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Devise $devise;

    #[ORM\Column(enumType: CardStatusEnum::class)]
    private CardStatusEnum $status;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $limitExceeded = false;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $holder;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCardType(): ?CardType
    {
        return $this->cardType;
    }

    public function setCardType(?CardType $cardType): static
    {
        $this->cardType = $cardType;

        return $this;
    }

    public function getCardNumberMask(): ?string
    {
        return $this->cardNumberMask;
    }

    public function setCardNumberMask(?string $cardNumberMask): static
    {
        $this->cardNumberMask = $cardNumberMask;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(?string $cardNumber): static
    {
        $this->cardNumber = $cardNumber;

        return $this;
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

    public function getSubLabel(): ?string
    {
        return $this->subLabel;
    }

    public function setSubLabel(?string $subLabel): static
    {
        $this->subLabel = $subLabel;

        return $this;
    }

    public function getVariante(): ?string
    {
        return $this->variante;
    }

    public function setVariante(?string $variante): static
    {
        $this->variante = $variante;

        return $this;
    }

    public function getPercentUsed(): ?string
    {
        return $this->percentUsed;
    }

    public function setPercentUsed(?string $percentUsed): static
    {
        $this->percentUsed = $percentUsed;

        return $this;
    }

    public function getIsPrincipal(): ?bool
    {
        return $this->isPrincipal;
    }

    public function setIsPrincipal(?bool $isPrincipal): static
    {
        $this->isPrincipal = $isPrincipal;

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

    public function getAmountExpendedThisMonthly(): ?string
    {
        return $this->amountExpendedThisMonthly;
    }

    public function setAmountExpendedThisMonthly(?string $amount): static
    {
        $this->amountExpendedThisMonthly = $amount;

        return $this;
    }

    public function getExpireMonth(): ?string
    {
        return $this->expireMonth;
    }

    public function setExpireMonth(?string $expireMonth): static
    {
        $this->expireMonth = $expireMonth;

        return $this;
    }

    public function getExpire(): ?string
    {
        return $this->expire;
    }

    public function setExpire(?string $expire): static
    {
        $this->expire = $expire;

        return $this;
    }

    public function getGaugeColor(): ?string
    {
        return $this->gaugeColor;
    }

    public function setGaugeColor(?string $gauge): static
    {
        $this->gaugeColor = $gauge;

        return $this;
    }


    public function getExpireYear():? string
    {
        return $this->expireYear;
    }

    public function setExpireYear(?string $expireYear): static
    {
        $this->expireYear = $expireYear;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(?string $cvv): static
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getStatus(): CardStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CardStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLimitExceeded():?bool
    {
        return $this->limitExceeded;
    }

    public function setLimitExceeded(?bool $limitExceeded): static
    {
        $this->limitExceeded = $limitExceeded;

        return $this;
    }

    public function getHolder(): ?string
    {
        return $this->holder;
    }

    public function setHolder(?string $holder): static
    {
        $this->holder = $holder;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
