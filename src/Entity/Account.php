<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Customer;
use App\Entity\Devise;
use App\Enum\AccountStatusEnum;
use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass:AccountRepository::class)]
#[ORM\Table(name: 'nexo_account')]
class Account
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $label;

     #[ORM\Column(type: 'boolean', nullable:true)]
    private ?bool $principal;

    #[ORM\Column(type: 'string', length: 14,nullable:true)]
    private ?string $accountNumber;

    #[ORM\Column(type: 'decimal', precision:14,scale:2)]
    private ?string $growthThisMonth;

    #[ORM\ManyToOne(targetEntity: AccountType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?AccountType $accountType;

    #[ORM\Column(enumType: AccountStatusEnum::class)]
    private AccountStatusEnum $status;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $amount;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $pendingAmount = '0.00';

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $outgoingAmount = '0.00';

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $blockedAmount = '0.00';

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $incomingAmount = '0.00';

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2,nullable:true)]
    private ?string $savingAmount = '0.00';

    #[ORM\ManyToOne(targetEntity: Devise::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Devise $devise;

    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    private ?string $iban;

    #[ORM\Column(type: 'string', length: 255,nullable:true)]
    private ?string $ibanFormatted;

    #[ORM\Column(type: 'string', length: 100,nullable:true)]
    private ?string $tag;

    #[ORM\Column(type: 'string', length: 34,nullable:true)]
    private ?string $category;

    #[ORM\Column(type: 'string', length: 11,nullable:true)]
    private ?string $bic;

    #[ORM\Column(type: 'string', length: 5,nullable:true)]
    private string $cleRib;

    #[ORM\Column(type: 'string', length: 5,nullable:true)]
    private ?string $codeBanque;

    #[ORM\Column(type: 'string', length: 5,nullable:true)]
    private ?string $codeGuichet;

    #[ORM\Column(type: 'datetime_immutable',nullable:true)]
    private ?\DateTimeImmutable $creationDate;

    #[ORM\Column(type: 'datetime_immutable',nullable:true)]
    private ?\DateTimeImmutable $modificationDate;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Transaction::class, orphanRemoval: true)]
    private Collection $transactions;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->transactions = new ArrayCollection();
        $this->creationDate = $this->modificationDate = new \DateTimeImmutable('now');
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): static
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAccountType(): ?AccountType
    {
        return $this->accountType;
    }

    public function setAccountType(?AccountType $accountType): static
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getStatus(): AccountStatusEnum
    {
        return $this->status;
    }

    public function setStatus(AccountStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPrincipal():?bool
    {
        return $this->principal;
    }

    public function setPrincipal(?bool $principal): static
    {
        $this->principal = $principal;

        return $this;
    }

     public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
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

    public function getPendingAmount(): ?string
    {
        return $this->pendingAmount;
    }

    public function setPendingAmount(?string $pendingAmount): static
    {
        $this->pendingAmount = $pendingAmount;

        return $this;
    }

    public function getBlockedAmount(): ?string
    {
        return $this->blockedAmount;
    }

    public function setBlockedAmount(?string $blockedAmount): static
    {
        $this->blockedAmount = $blockedAmount;

        return $this;
    }

    public function getOutgoingAmount(): ?string
    {
        return $this->outgoingAmount;
    }

    public function setOutgoingAmount(?string $outgoingAmount): static
    {
        $this->outgoingAmount = $outgoingAmount;

        return $this;
    }

    public function getIncomingAmount(): ?string
    {
        return $this->incomingAmount;
    }

    public function setIncomingAmount(?string $incomingAmount): static
    {
        $this->incomingAmount = $incomingAmount;

        return $this;
    }

    public function growthThisMonth(): ?string
    {
        return $this->growthThisMonth;
    }

    public function setGrowthThisMonth(?string $growthThisMonth): static
    {
        $this->growthThisMonth = $growthThisMonth;

        return $this;
    }

     public function getSavingAmount(): ?string
    {
        return $this->savingAmount;
    }

    public function setSavingAmount(?string $savingAmount): static
    {
        $this->savingAmount = $savingAmount;

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

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): static
    {
        $this->iban = $iban;

        return $this;
    }

    public function getIbanFormatted(): ?string
    {
        return $this->ibanFormatted;
    }

    public function setIbanFormatted(?string $ibanFormatted): static
    {
        $this->ibanFormatted = $ibanFormatted;

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

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(?string $bic): static
    {
        $this->bic = $bic;

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

    public function getCleRib(): ?string
    {
        return $this->cleRib;
    }

    public function setCleRib(?string $cleRib): static
    {
        $this->cleRib = $cleRib;

        return $this;
    }

    public function getCodeBanque(): ?string
    {
        return $this->codeBanque;
    }

    public function setCodeBanque(?string $codeBanque): static
    {
        $this->codeBanque = $codeBanque;

        return $this;
    }

    public function getCodeGuichet(): ?string
    {
        return $this->codeGuichet;
    }

    public function setCodeGuichet(?string $codeGuichet): static
    {
        $this->codeGuichet = $codeGuichet;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeImmutable $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): ?\DateTimeImmutable
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?\DateTimeImmutable $modificationDate): static
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $accountItem): static
    {
        if (!$this->transactions->contains($accountItem)) {
            $this->transactions->add($accountItem);
            $accountItem->setAccount($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $accountItem): static
    {
        $this->transactions->removeElement($accountItem);

        return $this;
    }
}
