<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\CryptoType;
use App\Repository\NexoCryptoAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: NexoCryptoAddressRepository::class)]
#[ORM\Table(name: 'nexo_crypto_address')]
class NexoCryptoAddress
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: CryptoType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CryptoType $cryptoType;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $address;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $active = true;

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

    public function getCryptoType(): ?CryptoType
    {
        return $this->cryptoType;
    }

    public function setCryptoType(?CryptoType $cryptoType): static
    {
        $this->cryptoType = $cryptoType;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
