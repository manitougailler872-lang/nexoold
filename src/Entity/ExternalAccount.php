<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Banque;
use App\Entity\Country;
use App\Entity\Customer;
use App\Enum\ExternalAccountStatus;
use App\Repository\ExternalAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ExternalAccountRepository::class)]
#[ORM\Table(name: 'nexo_external_account')]
class ExternalAccount
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'externalAccounts')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $firstname;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $lastname;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $bgColor;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $gender;

    #[ORM\ManyToOne(targetEntity: Banque::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Banque $banque;

    #[ORM\Column(type: 'string', length: 34, nullable: true)]
    private ?string $iban;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    private ?string $bicSwift;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country;

    #[ORM\Column(enumType: ExternalAccountStatus::class)]
    private ExternalAccountStatus $status;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): static
    {
        $this->banque = $banque;

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

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(?string $bgColor): static
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    public function getBicSwift(): ?string
    {
        return $this->bicSwift;
    }

    public function setBicSwift(?string $bicSwift): static
    {
        $this->bicSwift = $bicSwift;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getStatus(): ExternalAccountStatus
    {
        return $this->status;
    }

    public function setStatus(ExternalAccountStatus $status): static
    {
        $this->status = $status;

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
