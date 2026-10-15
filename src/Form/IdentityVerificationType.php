<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\DocumentType as DocType;
use App\Service\Upload\DocumentUploader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dossier de confirmation d'identité.
 * Les contraintes File ci-dessous sont une première barrière (confort
 * utilisateur, rejet précoce). La validation qui fait autorité reste celle du
 * DocumentUploader, qui inspecte le contenu réel du fichier.
 */
class IdentityVerificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fileConstraints = static fn (string $label, bool $required = true): array => array_filter([
            $required ? new Assert\NotNull(message: \sprintf('Le document « %s » est obligatoire.', $label)) : null,
            new Assert\File(
                maxSize: DocumentUploader::MAX_FILE_SIZE,
                mimeTypes: ['application/pdf', 'image/jpeg', 'image/png', 'image/heic'],
                mimeTypesMessage: 'Formats acceptés : PDF, JPEG, PNG, HEIC.',
                maxSizeMessage: 'Le fichier ne doit pas dépasser {{ limit }} {{ suffix }}.'
            ),
        ]);

        $builder
            ->add('identityDocumentType', ChoiceType::class, [
                'label' => "Type de pièce d'identité",
                'choices' => [
                    "Carte nationale d'identité" => DocType::IDENTITY_CARD->value,
                    'Passeport' => DocType::PASSPORT->value,
                ],
                'expanded' => true,
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('identityDocument', FileType::class, [
                'label' => "Pièce d'identité (recto-verso)",
                'mapped' => false,
                'required' => true,
                'constraints' => $fileConstraints("pièce d'identité"),
            ])
            ->add('proofOfAddress', FileType::class, [
                'label' => 'Justificatif de domicile de moins de 3 mois',
                'help' => "Facture d'électricité, d'eau, de gaz ou de téléphone fixe.",
                'mapped' => false,
                'required' => true,
                'constraints' => $fileConstraints('justificatif de domicile'),
            ])
            ->add('payslip', FileType::class, [
                'label' => 'Fiche de paie',
                'help' => 'Dernier bulletin de salaire.',
                'mapped' => false,
                'required' => false,
                'constraints' => $fileConstraints('fiche de paie', false),
            ])
            ->add('taxNotice', FileType::class, [
                'label' => "Avis d'imposition",
                'help' => "Dernier avis d'imposition reçu.",
                'mapped' => false,
                'required' => false,
                'constraints' => $fileConstraints("avis d'imposition", false),
            ])
            ->add('ribDocument', FileType::class, [
                'label' => "Relevé d'identité bancaire (RIB)",
                'mapped' => false,
                'required' => true,
                'constraints' => $fileConstraints('RIB'),
            ])
            ->add('iban', TextType::class, [
                'label' => 'IBAN',
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(message: 'Saisissez votre IBAN.'),
                    new Assert\Iban(message: "Cet IBAN n'est pas valide."),
                ],
                'attr' => [
                    'placeholder' => 'FR76 3000 1007 9412 3456 7890 185',
                    'autocomplete' => 'off',
                ],
            ])
            ->add('bic', TextType::class, [
                'label' => 'BIC / SWIFT',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\Bic(message: "Ce code BIC n'est pas valide."),
                ],
                'attr' => ['autocomplete' => 'off'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => true,
            'csrf_token_id' => 'identity_verification',
        ]);
    }
}
