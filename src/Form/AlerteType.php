<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Customer;
use App\Enum\TypeAlerteEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlerteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'email',
            ])
            ->add('type', EnumType::class, [
                'class' => TypeAlerteEnum::class,
                'choice_label' => static fn (TypeAlerteEnum $case): string => $case->label(),
            ])
            ->add('message', TextareaType::class)
            ->add('isRead', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeAlerteEnum::class,
        ]);
    }
}
