<?php

namespace App\Form;

use App\Config\Dice;
use App\Entity\Weapon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class WeaponFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Nom'
            ])
            ->add('damage', IntegerType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dégats'
            ])
            ->add('dice', EnumType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dè',
                'class' => Dice::class,
                'choice_label' => 'value'
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
