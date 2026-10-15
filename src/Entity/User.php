<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'nexo_user')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $identifier = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $password = '';

    #[ORM\Column(enumType: UserStatusEnum::class)]
    private ?UserStatusEnum $status;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $passwordAttempCount;

   #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $twoFactorEnable;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $identityConfirmed;

   #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $loanActivated;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $investmentActivated;

    #[ORM\Column(type: 'string', length:255, nullable: true)]
    private ?string $validationCode;

    #[ORM\Column(type: 'string', length:255, nullable: true)]
    private ?string $lastLoginFrom;

    #[ORM\Column(type: 'string', length:255, nullable: true)]
    private ?string $lastLoginIpAddress;

    #[ORM\Column(type: 'datetime',nullable: true)]
    private ?\DateTime $validationDate;

    #[ORM\ManyToOne(targetEntity:Langue::class,inversedBy:'user')]
    #[ORM\JoinColumn(nullable:true)]
    private ?Langue $language;

     #[ORM\OneToOne(
        mappedBy: 'user',
        targetEntity: Customer::class,
        cascade: ['persist', 'remove']
    )]
    private ?Customer $customer;

    #[ORM\ManyToOne(targetEntity:Devise::class,inversedBy:'user')]
    #[ORM\JoinColumn(nullable:true)]
    private ?Devise $devise;

    #[ORM\Column(type: 'decimal', precision:14, scale:2, nullable:true)]
    private ?string $virementPercent;

    #[ORM\Column(type: 'string', nullable:true)]
    private ?string $virementCode;

    #[ORM\Column(type: 'string', length:500,  nullable:true)]
    private ?string $virementMessage;

    #[ORM\Column(type: 'integer', nullable:true)]
    private ?int $validationAttemptCount;

    #[ORM\Column(type:'datetime_immutable', nullable:true)]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(type:'datetime', nullable:true)]
    private ?\DateTime $lastLoginAt = null;

    #[ORM\Column(type:'datetime_immutable', nullable:true)]
    private \DateTimeImmutable $createdAt;

    public function __construct() { 
        $this->createdAt =  $this->updatedAt = new \DateTimeImmutable(); 
        $this->id = Uuid::v7();
    }

    #[ORM\PreUpdate]
    public function preUpdate():void {
            $this->updatedAt = new \DateTimeImmutable();
    }

    public function getFullname():string{
        return sprintf('%s %s', $this->customer->getFirstname(), $this->customer->getLastname());
    }

    public function getInitials():string{
        return sprintf('%s%s', substr(ucfirst($this->customer->getFirstname()),0,1), 
        substr(ucfirst($this->customer->getLastname()),0,1));
    }

    public function getId(): Uuid { return $this->id; }
    public function getUserIdentifier(): string { return $this->identifier; }
    public function setUserIdentifier(string $v): static { $this->identifier =$v; return $this; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $v): self { $this->password = $v; return $this; }

    public function getLastLoginFrom(): ?string { return $this->lastLoginFrom; }
    public function settLastLoginFrom(?string $v): self { $this->lastLoginFrom = $v; return $this; }

    public function getLastLoginIpAddress(): ?string { return $this->lastLoginIpAddress; }
    public function setLastLoginIpAddress(?string $v): self { $this->lastLoginIpAddress = $v; return $this; }

    public function getStatus(): UserStatusEnum { return $this->status; }
    public function setStatus(UserStatusEnum $v): self { $this->status = $v; return $this; }

    public function getValidationAttemptCount(): ?int { return $this->validationAttemptCount; }
    public function setValidationAttemptCount(?int  $v): self { $this->validationAttemptCount = $v; return $this; }

    public function getPasswordAttemptCount(): ?int { return $this->passwordAttempCount; }
    public function setPasswordAttemptCount(?int $v): self { $this->passwordAttempCount = $v; return $this; }
    public function getTwoFactorEnable():? bool { return $this->twoFactorEnable; }
    public function setTwoFactorEnable(?bool $v): self { $this->twoFactorEnable = $v; return $this; }

    public function getIdentityConfirmed():?bool { return $this->identityConfirmed; }
    public function setIdentityConfirmed(?bool $v): self { $this->identityConfirmed = $v; return $this; }
    public function getLoanActivated(): ?bool { return $this->loanActivated; }
    public function setLoanActivated(?bool $v): self { $this->loanActivated = $v; return $this; }
    public function getInvestmentActivated(): ?bool { return $this->investmentActivated; }
    public function setInvestmentActivated(?bool $v): self { $this->investmentActivated = $v; return $this; }

    public function getValidationCode(): ?string { return $this->validationCode; }
    public function setValidationCode(?string $v): self { $this->validationCode = $v; return $this; }

    public function getValidationDate(): ?\DateTime { return $this->validationDate; }
    public function setValidationDate(?\DateTime $v): self { $this->validationDate = $v; return $this; }

    public function getDevise(): ?Devise { return $this->devise; }
    public function setDevise(?Devise $v): self { $this->devise = $v; return $this; }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        if ($customer !== null && $customer->getUser() !== $this) {
            $customer->setUser($this);
        }

        return $this;
    }

    public function getLangue(): ?Langue { return $this->language; }
    public function setLangue(?Langue $v): self { $this->language = $v; return $this; }

    public function getVirementPercent(): ?string { return $this->virementPercent; }
    public function setVirementPercent(?string $v): self { $this->virementPercent = $v; return $this; }
    public function getVirementCode(): ?string { return $this->virementCode; }
    public function setVirementCode(?string $v): self { $this->virementCode = $v; return $this; }
    public function getVirementMessage(): ?string { return $this->virementMessage; }
    public function setVirementMessage(?string $v): self { $this->virementMessage = $v; return $this; }

    public function incrementPasswordAttemptCount():static {
        ++$this->passwordAttempCount;
        return $this;
    }

      // ---------------------------------------------------------------
    // Règles métier d'accès
    // ---------------------------------------------------------------

    public function isBlocked(): bool
    {
        return UserStatusEnum::PENDING === $this->status && $this->passwordAttempCount >= 5;
    }

    public function incrementValidationAttemptCount(): static
    {
        ++$this->validationAttemptCount;
        return $this;
    }

    public function isOtpExpired(int $ttlSeconds): bool
    {
        if (null === $this->validationDate) {
            return true;
        }

        return $this->validationDate->getTimestamp() + $ttlSeconds < time();
    }

    public function clearOtp(): static
    {
        $this->validationCode = null;
        $this->validationDate = null;
        $this->validationAttemptCount = 0;

        return $this;
    }

    public function touch(): static
    {
        $this->updatedAt = new \DateTimeImmutable();
        return $this;
    }
    
   
    /** @return list<string> */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_values(array_unique($roles));
    }

    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    public function getLastLoginAt(): ?\DateTime { return $this->lastLoginAt; }
    public function setLastLoginAt(?\DateTime $v): self { $this->lastLoginAt = $v; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function eraseCredentials(): void {}
}
