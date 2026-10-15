<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\TypeAlerteEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de sélection du type d'alerte (App\Enum\TypeAlerte).
 *
 * NB : dans le modèle (cf. diagramme de classes), TypeAlerte est un ENUM et non
 * une entité CRUD-able. Ce FormType expose donc un simple champ de sélection,
 * destiné aux formulaires de filtre/admin. Le formulaire complet de gestion
 * d'une alerte se trouve dans AlerteType.
 */
class AlertTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => TypeAlerteEnum::class,
                'choice_label' => static fn (TypeAlerteEnum $type): string => $type->label(),
                'placeholder' => 'Choisir un type d\'alerte',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
