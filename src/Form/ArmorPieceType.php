<?php

namespace App\Form;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmorPieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('location', EntityType::class,[
            'class' => ArmorLocation::class,
            "label" => "Localisation",
            'choice_label' => 'name'
            ])
        ->add('type', EntityType::class,[
            "label" => "Type",
            'class' => ArmorType::class,
            'choice_label' => 'name'
        ])
        ->add('value')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArmorPiece::class,
        ]);
    }
}
