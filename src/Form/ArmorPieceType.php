<?php

namespace App\Form;

use App\Entity\ArmorLocation;
use App\Entity\ArmorPiece;
use App\Entity\ArmorType;
use App\Repository\ArmorLocationRepository;
use App\Repository\ArmorTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmorPieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('location', EntityType::class,[
            'class' => ArmorLocation::class,
            'query_builder' => function (ArmorLocationRepository $alr) {
                return $alr->createQueryBuilder('al')
                    ->orderBy('al.name', 'ASC');
            },
            'choice_label' => 'name',
            "label" => "Localisation"
            ])
        ->add('type', EntityType::class,[
            'class' => ArmorType::class,
            'query_builder' => function (ArmorTypeRepository $atr) {
                return $atr->createQueryBuilder('at')
                    ->orderBy('at.name', 'ASC');
            },
            'choice_label' => 'name',
            "label" => "Type",
        ])
        ->add('physicalAbsorption', IntegerType::class, [
            "label" => 'Résistance physique'
        ])
        ->add('magicalAbsorption', IntegerType::class, [
            "label" => 'Résistance magique'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArmorPiece::class,
        ]);
    }
}
