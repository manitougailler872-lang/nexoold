<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accountNumber', TextType::class, [
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(message: 'Saisissez votre identifiant.'),
                    new Assert\Regex(
                        pattern: '/^\d{10}$/',
                        message: 'L\'identifiant doit comporter exactement 10 chiffres.'
                    ),
                ],
                'attr' => [
                    'class' => 'w-full h-14 px-4 pr-4 rounded-xl border border-line bg-white text-md placeholder:text-ink-4 focus:outline-none focus:border-nexo-600 transition-colors',
                    'inputmode' => 'numeric',
                    'autocomplete' => 'username',
                    'maxlength' => 10,
                    'placeholder' => 'Entrer nom d\'utilisateur ou no de la carte',
                ],
            ])
            ->add('secretCode', HiddenType::class, [
                'attr' => [
                    'data-code-positions' => ''
                ]
                // 'label' => 'Code secret (6 chiffres)',
                // 'constraints' => [
                //     new Assert\NotBlank(message: 'Saisissez votre code secret.'),
                //     new Assert\Regex(
                //         pattern: '/^\d{6}$/',
                //         message: 'Le code secret doit comporter exactement 6 chiffres.'
                //     ),
                // ],
                // 'attr' => [
                //     'inputmode' => 'numeric',
                //     'autocomplete' => 'current-password',
                //     'maxlength' => 6,
                // ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => true,
            'csrf_token_id' => 'authenticate',
        ]);
    }
}
