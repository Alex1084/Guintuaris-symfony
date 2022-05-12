<?php

namespace App\Form;

use App\Entity\Weapon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Nom'
            ])
            ->add('damage', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dégats'
            ])
            ->add('dice', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dè'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Weapon::class,
        ]);
    }
}
