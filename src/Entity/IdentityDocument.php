<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\DocumentTypeEnum;
use App\Repository\IdentityDocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Métadonnées d'un justificatif téléversé.
 *
 * Le fichier lui-même n'est JAMAIS dans /public : il est stocké sous
 * %kernel.project_dir%/var/secure_uploads/{userId}/{storedName} et servi
 * uniquement via un contrôleur qui contrôle les droits.
 */
#[ORM\Entity(repositoryClass: IdentityDocumentRepository::class)]
#[ORM\Table(name: 'nexo_identity_document')]
class IdentityDocument
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: IdentityVerification::class, inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: true)]
    private ?IdentityVerification $verification;

    #[ORM\Column(enumType: DocumentTypeEnum::class)]
    private DocumentTypeEnum $type;

    /** Nom d'origine, assaini — sert uniquement à l'affichage. */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $originalName;

    /** Nom sur disque : {uuid}.{ext}, jamais dérivé du nom fourni par le client. */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $storedName;

    /** MIME réel détecté par finfo, pas celui annoncé par le navigateur. */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $mimeType;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $size;

    /** SHA-256 du fichier : détection de doublon et preuve d'intégrité. */
    #[ORM\Column(type: 'string', length: 64)]
    private ?string $checksum;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $uploadedAt;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->uploadedAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getVerification(): ?IdentityVerification
    {
        return $this->verification;
    }

    public function setVerification(?IdentityVerification $verification): static
    {
        $this->verification = $verification;

        return $this;
    }

    public function getType(): DocumentTypeEnum
    {
        return $this->type;
    }

    public function setType(DocumentTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getStoredName(): ?string
    {
        return $this->storedName;
    }

    public function setStoredName(?string $storedName): static
    {
        $this->storedName = $storedName;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): static
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getSize():? int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getChecksum(): ?string
    {
        return $this->checksum;
    }

    public function setChecksum(?string $checksum): static
    {
        $this->checksum = $checksum;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }
}
