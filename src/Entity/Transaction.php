<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\CategoryExpense;
use App\Entity\Customer;
use App\Entity\TypeTransaction;
use App\Enum\OperationTypeEnum;
use App\Enum\TransactionStatusEnum;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: '`nexo_transaction`')]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Devise::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Devise $devise;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Account $account;

    #[ORM\ManyToOne(targetEntity: TypeTransaction::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?TypeTransaction $transType;

    #[ORM\ManyToOne(targetEntity: CategoryExpense::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CategoryExpense $category;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2)]
    private ?string $amount;

    #[ORM\Column(type: 'datetime', nullable:true)]
    private ?\DateTime $transDate;

    #[ORM\Column(enumType: TransactionStatusEnum::class)]
    private TransactionStatusEnum $status;

    #[ORM\Column(enumType: OperationTypeEnum::class)]
    private OperationTypeEnum $operation;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $metadata = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $holder = null;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getTransType(): ?TypeTransaction
    {
        return $this->transType;
    }

    public function setTransType(?TypeTransaction $transType): static
    {
        $this->transType = $transType;

        return $this;
    }

    public function getCategory(): ?CategoryExpense
    {
        return $this->category;
    }

    public function setCategory(?CategoryExpense $category): static
    {
        $this->category = $category;

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

    public function getTransDate(): ?\DateTime
    {
        return $this->transDate;
    }

    public function setTransDate(?\DateTime $transDate): static
    {
        $this->transDate = $transDate;

        return $this;
    }

    public function getStatus(): TransactionStatusEnum
    {
        return $this->status;
    }

    public function setStatus(TransactionStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOperation(): OperationTypeEnum
    {
        return $this->operation;
    }

    public function setOperation(OperationTypeEnum $operation): static
    {
        $this->operation = $operation;

        return $this;
    }

    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function setMetadata(?array $metadata): static
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

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

    public function getCreatedAt():? \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
