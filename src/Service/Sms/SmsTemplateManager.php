<?php

declare(strict_types=1);

namespace App\Service\Sms;

use App\Service\Sms\Dto\SmsMessage;

/**
 * Centralise les modèles de SMS "pro" pour éviter les textes en dur
 * dispersés dans les contrôleurs/services métier.
 *
 * Placeholders au format {cle}, remplacés via strtr().
 */
final class SmsTemplateManager
{
    /** @var array<string,string> */
    private const TEMPLATES = [
        'rappel_rendezvous' =>
            'Bonjour {prenom}, rappel de votre rendez-vous le {date} à {heure} pour {objet}. '
            . 'NexoBanq- {adresse}.',

        'otp_verification' =>
            'Votre code de vérification NexoBanqest {code}. Il expire dans {duree} minutes. '
            . 'Ne le communiquez à personne.',

        'bienvenue' =>
            'Bienvenue {prenom} ! Votre compte NexoBanq est activé. '
            . 'Découvrez nos véhicules disponibles dès maintenant : {lien}.',
    ];

    /**
     * @param array<string,string|int|float> $params
     */
    public function render(string $templateKey, array $params): string
    {
        if (!isset(self::TEMPLATES[$templateKey])) {
            throw new \InvalidArgumentException(sprintf('Template SMS inconnu : "%s".', $templateKey));
        }

        $replacements = [];
        foreach ($params as $key => $value) {
            $replacements['{' . $key . '}'] = (string) $value;
        }

        $rendered = strtr(self::TEMPLATES[$templateKey], $replacements);

        // Sécurité : signale les placeholders oubliés plutôt que de les envoyer tels quels au client.
        if (preg_match('/\{[a-zA-Z0-9_]+\}/', $rendered, $matches)) {
            throw new \InvalidArgumentException(sprintf(
                'Placeholder manquant "%s" pour le template "%s".',
                $matches[0],
                $templateKey
            ));
        }

        return $rendered;
    }

    /**
     * Construit directement un SmsMessage prêt à être envoyé à partir d'un template.
     *
     * @param array<string,string|int|float> $params
     */
    public function createMessage(string $to, string $templateKey, array $params, ?string $from = null): SmsMessage
    {
        return new SmsMessage(
            to: $to,
            body: $this->render($templateKey, $params),
            from: $from,
            templateKey: $templateKey,
            context: $params,
        );
    }

    /**
     * @return string[]
     */
    public function availableTemplates(): array
    {
        return array_keys(self::TEMPLATES);
    }
}
