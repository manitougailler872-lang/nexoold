<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\MaritalStatusEnum;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'nexo_customer')]
class Customer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $firstname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $reference = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lastname = '';

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $gender = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = '';

    #[ORM\Column(type:'datetime',  nullable:true)]
    private ?\DateTime $dateOBirth = null;

    #[ORM\Column(type: 'string', length: 59, nullable: true)]
    private ?string $countryOfBirth = null;

    #[ORM\Column(type: 'string', length: 59, nullable: true)]
    private ?string $salaryDevise = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $postalCode = null;

   #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $identityPhoto = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cardIdType = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $cardIdNumber = null;

    #[ORM\Column(type:'datetime', nullable: true)]
    private ?\DateTime $cardIdExpiredDate = null;

    #[ORM\Column(type: 'decimal', precision:14, scale:2, nullable: true)]
    private ?string $salary = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $employmentType;

    #[ORM\Column(enumType: MaritalStatusEnum::class, nullable:true)]
    private ?MaritalStatusEnum $maritalStatus;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $phoneCountryCode;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $phoneNumber;

   #[ORM\OneToOne(
        inversedBy: 'customer',
        targetEntity: User::class
    )]
    #[ORM\JoinColumn(
        nullable: true,
        unique: true,
        onDelete: 'CASCADE'
    )]
    private ?User $user = null;

    
   #[ORM\OneToOne(
        inversedBy: 'customer',
        targetEntity: Flashy::class
    )]
    #[ORM\JoinColumn(
        nullable: true,
        onDelete: 'CASCADE'
    )]
    private ?Flashy $flashy = null;

   #[ORM\Column(type:'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt;

   #[ORM\Column(type:'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

     #[ORM\OneToMany(targetEntity:ExternalAccount::class, mappedBy:'customer')]
    private Collection $externalAccounts;

    #[ORM\OneToMany(targetEntity:Message::class, mappedBy:'customer')]
    private Collection $messages;

    #[ORM\OneToMany(targetEntity:Alert::class, mappedBy:'customer')]
    private Collection $alerts;

    #[ORM\OneToMany(targetEntity:Account::class, mappedBy:'customer')]
    private Collection $accounts;

    #[ORM\OneToMany(targetEntity:Card::class, mappedBy:'customer')]
    private Collection $cards;

    #[ORM\OneToMany(targetEntity:CustomerCryptoAddress::class, mappedBy:'customer')]
    private Collection $cryptoAddresses;

    #[ORM\OneToMany(targetEntity:Transaction::class, mappedBy:'customer')]
    private Collection $transactions;

    public  function __construct() {
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable('now');
        $this->externalAccounts = new ArrayCollection();
        $this->id = Uuid::v7();
    }

    public function getId(): ?Uuid {return $this->id;}

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(?string $v): self { $this->phoneNumber = $v; return $this; }

     public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        if ($user !== null && $user->getCustomer() !== $this) {
            $user->setCustomer($this);
        }

        return $this;
    }

       public function getFlashy(): ?Flashy
    {
        return $this->flashy;
    }

    public function setFlashy(?Flashy $flashy): static
    {
        $this->flashy = $flashy;

        if ($flashy !== null && $flashy->getCustomer() !== $this) {
            $flashy->setCustomer($this);
        }
        return $this;
    }


    public function getPhoneCountryCode(): ?string { return $this->phoneCountryCode; }
    public function setPhoneCountryCode(?string $v): self { $this->phoneCountryCode = $v; return $this; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(?string $v): self { $this->firstname = $v; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(?string $v): self { $this->lastname = $v; return $this; }

    public function getCardIdType(): ?string { return $this->cardIdType; }
    public function setCardIdType(?string $v): self { $this->cardIdType = $v; return $this; }

    public function getCardIdNumber(): ?string { return $this->cardIdNumber; }
    public function setCardIdNumber(?string $v): self { $this->cardIdNumber = $v; return $this; }

    public function getPostalCode(): ?string { return $this->postalCode; }
    public function setPostalCode(?string $v): self { $this->postalCode = $v; return $this; }

    public function getReference(): ?string { return $this->reference; }
    public function setReference(?string $v): self { $this->reference = $v; return $this; }
    
    public function getSalary(): ?string { return $this->salary; }
    public function setSalary(?string $v): self { $this->salary = $v; return $this; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(?string $v): self { $this->city = $v; return $this; }

    public function getSalaryDevise(): ?string { return $this->salaryDevise; }
    public function setSalaryDevise(?string $v): self { $this->salaryDevise = $v; return $this; }

    public function getIdentityPhoto(): ?string { return $this->identityPhoto; }
    public function setIdentityPhoto(?string $v): self { $this->identityPhoto = $v; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $v): self { $this->email = $v; return $this; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $v): self { $this->address = $v; return $this; }

    public function getGender(): ?string { return $this->gender; }
    public function setGender(?string $v): self { $this->gender = $v; return $this; }

    public function getEmploymentType(): ?string { return $this->employmentType; }
    public function setEmploymentType(?string $v): self { $this->employmentType = $v; return $this; }

    public function getNationality(): ?string { return $this->nationality; }
    public function setNationality(?string $v): self { $this->nationality = $v; return $this; }

    public function getCardIdExpiredDate(): ?\DateTime { return $this->cardIdExpiredDate; }
    public function setCardIdExpiredDate(?\DateTime $v): self { $this->cardIdExpiredDate = $v; return $this; }

    public function getDateOfBirth(): ?\DateTime { return $this->dateOBirth; }
    public function setDateOfBirth(?\DateTime $v): self { $this->dateOBirth = $v; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(?\DateTimeImmutable $v): self { $this->createdAt = $v; return $this; }

    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(?\DateTimeImmutable $v): self { $this->updatedAt = $v; return $this; }

    public function getMaritalStatus(): ?MaritalStatusEnum { return $this->maritalStatus; }
    public function setMaritalStatus(?MaritalStatusEnum $v): self { $this->maritalStatus = $v; return $this; }

    public function getCountryOfBirth(): ?string { return $this->countryOfBirth; }
    public function setCountryOfBirth(?string $v): self { $this->countryOfBirth = $v; return $this; }

    public function getExternalAccounts(): \Doctrine\Common\Collections\Collection { return $this->externalAccounts; }
    public function getAccounts(): \Doctrine\Common\Collections\Collection { return $this->accounts; }
    public function getMessages(): \Doctrine\Common\Collections\Collection { return $this->messages; }
    public function getAlerts(): \Doctrine\Common\Collections\Collection { return $this->alerts; }
    public function getCards(): \Doctrine\Common\Collections\Collection { return $this->cards; }
    public function getCryptoAddresses(): \Doctrine\Common\Collections\Collection { return $this->cryptoAddresses; }
    public function getTransactions(): \Doctrine\Common\Collections\Collection { return $this->transactions; }
}