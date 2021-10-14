<?php

namespace App\Form;

use App\Entity\LocalisationArmure;
use App\Entity\PieceArmure;
use App\Entity\TypeArmure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieceArmureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('localisation', EntityType::class,[
                'class' => LocalisationArmure::class,
                    'choice_label' => 'nom'
                ])
            ->add('type', EntityType::class,[
                'class' => TypeArmure::class,
                'choice_label' => 'nom'
            ])
            ->add('valeur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PieceArmure::class,
        ]);
    }
}
