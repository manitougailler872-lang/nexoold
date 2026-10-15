<?php

declare(strict_types=1);

namespace App\Service\Upload;

use App\Entity\IdentityDocument;
use App\Entity\IdentityVerification;
use App\Enum\DocumentTypeEnum;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

/**
 * Stockage des justificatifs KYC.
 *
 * Règles appliquées :
 *  - le répertoire de destination est SOUS var/, jamais sous public/ : même
 *    mal configuré, le serveur web ne peut pas servir ni exécuter ces fichiers ;
 *  - le type MIME est déterminé par inspection du contenu (finfo), pas par
 *    l'en-tête Content-Type ni par l'extension, tous deux contrôlés par le client ;
 *  - le nom sur disque est un UUID : aucune donnée fournie par l'utilisateur
 *    n'entre dans un chemin (pas de traversée de répertoire, pas de collision) ;
 *  - l'extension est déduite du MIME validé, jamais recopiée de l'entrée ;
 *  - les permissions sont réduites à 0640 sur le fichier, 0750 sur le dossier.
 */
final class DocumentUploader
{
    public const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 Mo

    /** MIME réels autorisés => extension canonique imposée. */
    private const ALLOWED_MIME = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/heic' => 'heic',
    ];

    private readonly Filesystem $filesystem;

    public function __construct(
        #[Autowire('%kernel.project_dir%/var/secure_uploads')]
        private readonly string $storageRoot,
    ) {
        $this->filesystem = new Filesystem();
    }

    /**
     * @throws UploadRejectedException si le fichier ne satisfait pas les contrôles
     */
    public function store(
        UploadedFile $file,
        DocumentTypeEnum $type,
        IdentityVerification $verification,
    ): IdentityDocument {
        if (!$file->isValid()) {
            throw new UploadRejectedException('Le téléversement a échoué : '.$file->getErrorMessage());
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new UploadRejectedException(\sprintf(
                'Le fichier dépasse la taille maximale de %d Mo.',
                (int) (self::MAX_FILE_SIZE / 1024 / 1024)
            ));
        }

        if (0 === $file->getSize()) {
            throw new UploadRejectedException('Le fichier est vide.');
        }

        // MIME réel : on lit les octets, on ne fait pas confiance au client.
        $finfo = new \finfo(\FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($file->getPathname());

        if (false === $realMime || !isset(self::ALLOWED_MIME[$realMime])) {
            throw new UploadRejectedException(
                'Format non accepté. Formats autorisés : PDF, JPEG, PNG, HEIC.'
            );
        }

        $extension = self::ALLOWED_MIME[$realMime];
        $storedName = Uuid::v7()->toRfc4122().'.'.$extension;

        $checksum = hash_file('sha256', $file->getPathname());

        if (false === $checksum) {
            throw new UploadRejectedException('Impossible de calculer l\'empreinte du fichier.');
        }

        $targetDir = $this->directoryFor($verification);
        $this->filesystem->mkdir($targetDir, 0750);

        $file->move($targetDir, $storedName);
        $this->filesystem->chmod($targetDir.'/'.$storedName, 0640);

        $document = new IdentityDocument();
        $document
            ->setType($type)
            ->setOriginalName($this->sanitizeName($file->getClientOriginalName()))
            ->setStoredName($storedName)
            ->setMimeType($realMime)
            ->setSize((int) filesize($targetDir.'/'.$storedName))
            ->setChecksum($checksum);

        $verification->addDocument($document);

        return $document;
    }

    public function absolutePath(IdentityDocument $document): string
    {
        return $this->directoryFor($document->getVerification()).'/'.$document->getStoredName();
    }

    public function remove(IdentityDocument $document): void
    {
        $this->filesystem->remove($this->absolutePath($document));
    }

    private function directoryFor(IdentityVerification $verification): string
    {
        return $this->storageRoot.'/'.$verification->getUser()->getId()->toRfc4122();
    }

    /**
     * Le nom d'origine ne sert QU'À l'affichage. On le neutralise quand même :
     * il finira dans du HTML et potentiellement dans un en-tête HTTP.
     */
    private function sanitizeName(string $name): string
    {
        $name = basename($name);
        $name = preg_replace('/[^\w\-. ]/u', '_', $name) ?? 'document';

        return mb_substr($name, 0, 255);
    }
}
