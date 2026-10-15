<?php

declare(strict_types=1);

namespace App\Service\Crypto;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Chiffrement authentifié AES-256-GCM des IBAN.
 *
 * Format stocké : base64( nonce(12) || tag(16) || ciphertext ).
 * GCM fournit confidentialité ET intégrité : une modification en base est
 * détectée au déchiffrement (openssl_decrypt renvoie false).
 *
 * La clé provient de APP_IBAN_KEY (32 octets encodés en base64). Elle ne doit
 * jamais être commitée et doit être différente par environnement.
 */
final class IbanEncryptor
{
    private const CIPHER = 'aes-256-gcm';
    private const NONCE_LEN = 12;
    private const TAG_LEN = 16;

    private string $key;

    public function __construct(
        #[Autowire('%env(APP_IBAN_KEY)%')]
        string $base64Key,
    ) {
        $key = base64_decode($base64Key, true);

        if (false === $key || 32 !== \strlen($key)) {
            throw new \RuntimeException(
                'APP_IBAN_KEY doit être une clé de 32 octets encodée en base64. '
                ."Générez-la avec : php -r \"echo base64_encode(random_bytes(32));\""
            );
        }

        $this->key = $key;
    }

    public function encrypt(string $plaintext): string
    {
        $nonce = random_bytes(self::NONCE_LEN);
        $tag = '';

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $this->key,
            \OPENSSL_RAW_DATA,
            $nonce,
            $tag,
            '',
            self::TAG_LEN
        );

        if (false === $ciphertext) {
            throw new \RuntimeException('Échec du chiffrement de l\'IBAN.');
        }

        return base64_encode($nonce.$tag.$ciphertext);
    }

    public function decrypt(string $encoded): string
    {
        $raw = base64_decode($encoded, true);

        if (false === $raw || \strlen($raw) <= self::NONCE_LEN + self::TAG_LEN) {
            throw new \RuntimeException('Donnée chiffrée invalide.');
        }

        $nonce = substr($raw, 0, self::NONCE_LEN);
        $tag = substr($raw, self::NONCE_LEN, self::TAG_LEN);
        $ciphertext = substr($raw, self::NONCE_LEN + self::TAG_LEN);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $this->key,
            \OPENSSL_RAW_DATA,
            $nonce,
            $tag
        );

        if (false === $plaintext) {
            // Mauvaise clé, ou donnée altérée en base.
            throw new \RuntimeException('Déchiffrement impossible : donnée altérée ou clé incorrecte.');
        }

        return $plaintext;
    }

    /**
     * Normalise un IBAN saisi (espaces, casse) avant chiffrement.
     */
    public static function normalize(string $iban): string
    {
        return strtoupper(preg_replace('/\s+/', '', $iban) ?? '');
    }
}
