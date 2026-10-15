<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\CryptoType;
use App\Entity\User;
use App\Enum\CryptoRequestStatus;
use App\Enum\CryptoRequestStatusEnum;
use App\Repository\WithdrawCryptoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: WithdrawCryptoRepository::class)]
#[ORM\Table(name: 'nexo_withdraw_crypto')]
class WithdrawCrypto
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: CryptoType::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CryptoType $cryptoType;

    #[ORM\Column(type: 'string', length: 191,nullable: true)]
    private ?string $toAddress;

    #[ORM\Column(type: 'decimal', precision: 18, scale: 8,nullable: true)]
    private ?string $amount;

    #[ORM\Column(enumType: CryptoRequestStatusEnum::class)]
    private CryptoRequestStatusEnum $status;

    #[ORM\Column(type: 'string', length: 191, nullable: true)]
    private ?string $txHash = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
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

    public function getToAddress(): ?string
    {
        return $this->toAddress;
    }

    public function setToAddress(?string $toAddress): static
    {
        $this->toAddress = $toAddress;

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

    public function getStatus(): CryptoRequestStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CryptoRequestStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTxHash(): ?string
    {
        return $this->txHash;
    }

    public function setTxHash(?string $txHash): static
    {
        $this->txHash = $txHash;

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
