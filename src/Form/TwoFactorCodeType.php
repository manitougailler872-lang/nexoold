<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TwoFactorCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code de validation',
                'constraints' => [
                    new Assert\NotBlank(message: 'Saisissez le code reçu.'),
                    new Assert\Regex(
                        pattern: '/^\d{6}$/',
                        message: 'Le code comporte 6 chiffres.'
                    ),
                ],
                'attr' => [
                    'inputmode' => 'numeric',
                    'autocomplete' => 'one-time-code',
                    'maxlength' => 6,
                    'autofocus' => true,
                    'placeholder' => '••••••',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => true,
            'csrf_token_id' => 'two_factor',
        ]);
    }
}
