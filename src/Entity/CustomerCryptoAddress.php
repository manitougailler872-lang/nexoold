<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\CryptoType;
use App\Entity\Customer;
use App\Repository\CustomerCryptoAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CustomerCryptoAddressRepository::class)]
#[ORM\Table(name: 'nexo_customer_crypto_address')]
class CustomerCryptoAddress
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'cryptoAddresses')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    #[ORM\ManyToOne(targetEntity: CryptoType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CryptoType $cryptoType;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private  ?string $address;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private  ?string $label;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private  ?\DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer():  ?Customer
    {
        return $this->customer;
    }

    public function setCustomer( ?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCryptoType():  ?CryptoType
    {
        return $this->cryptoType;
    }

    public function setCryptoType( ?CryptoType $cryptoType): static
    {
        $this->cryptoType = $cryptoType;

        return $this;
    }

    public function getAddress():  ?string
    {
        return $this->address;
    }

    public function setAddress( ?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getLabel():  ?string
    {
        return $this->label;
    }

    public function setLabel( ?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCreatedAt():  ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
