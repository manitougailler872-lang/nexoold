<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\VerificationStatus;
use App\Enum\VerificationStatusEnum;
use App\Repository\IdentityVerificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Dossier de confirmation d'identité (KYC) d'un utilisateur.
 *
 * L'IBAN n'est jamais stocké en clair : il est chiffré en AES-256-GCM
 * (voir App\Service\Crypto\IbanEncryptor) et seuls les 4 derniers caractères
 * sont conservés en clair pour l'affichage.
 */
#[ORM\Entity(repositoryClass: IdentityVerificationRepository::class)]
#[ORM\Table(name: 'nexo_identity_verification')]
class IdentityVerification
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user;

    #[ORM\Column(enumType: VerificationStatusEnum::class)]
    private VerificationStatusEnum $status = VerificationStatusEnum::DRAFT;

    /** IBAN chiffré : base64(nonce || tag || ciphertext). */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ibanEncrypted = null;

    /** 4 derniers caractères de l'IBAN, pour affichage (ex. « •••• 3021 »). */
    #[ORM\Column(type: 'string', length: 4, nullable: true)]
    private ?string $ibanLast4 = null;

    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    private ?string $bic = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $rejectionReason = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $submittedAt = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $reviewedAt = null;

    #[ORM\OneToMany(mappedBy: 'verification', targetEntity: IdentityDocument::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $documents;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(User $user)
    {
        $this->id = Uuid::v7();
        $this->user = $user;
        $this->documents = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getStatus(): VerificationStatusEnum
    {
        return $this->status;
    }

    public function setStatus(VerificationStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIbanEncrypted(): ?string
    {
        return $this->ibanEncrypted;
    }

    public function setIbanEncrypted(?string $ibanEncrypted): static
    {
        $this->ibanEncrypted = $ibanEncrypted;

        return $this;
    }

    public function getIbanLast4(): ?string
    {
        return $this->ibanLast4;
    }

    public function setIbanLast4(?string $ibanLast4): static
    {
        $this->ibanLast4 = $ibanLast4;

        return $this;
    }

    public function getMaskedIban(): string
    {
        return null === $this->ibanLast4 ? '—' : '•••• •••• '.$this->ibanLast4;
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

    public function getRejectionReason(): ?string
    {
        return $this->rejectionReason;
    }

    public function setRejectionReason(?string $reason): static
    {
        $this->rejectionReason = $reason;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeImmutable
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(?\DateTimeImmutable $at): static
    {
        $this->submittedAt = $at;

        return $this;
    }

    public function getReviewedAt(): ?\DateTimeImmutable
    {
        return $this->reviewedAt;
    }

    public function setReviewedAt(?\DateTimeImmutable $at): static
    {
        $this->reviewedAt = $at;

        return $this;
    }

    /**
     * @return Collection<int, IdentityDocument>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(IdentityDocument $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setVerification($this);
        }

        return $this;
    }

    public function removeDocument(IdentityDocument $document): static
    {
        $this->documents->removeElement($document);

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isEditable(): bool
    {
        return \in_array($this->status, [VerificationStatusEnum::DRAFT, VerificationStatusEnum::REJECTED], true);
    }
}
