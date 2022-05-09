<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Classe;
use App\Entity\Race;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name')
        ->add('pvMax', IntegerType::class, [
            "attr" => [
                "min" => 10,
                "class" => "input-form",
            ],
            'label' => 'PV'
        ])
        ->add('pcMax', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "class" => "input-form",
            ],
            'label' => 'PC'
        ])
        ->add('pmMax', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "class" => "input-form",
            ],
            'label' => 'PM'
        ])
        ->add('level', IntegerType::class, [
            "attr" => [
                "min" => 1,
                "max" => 10,
                "class" => "input-form",

            ]
        ])
        ->add('constitution', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",

            ]
        ])
        ->add('strength', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",

            ],
            'label' => 'Force'
        ])
        ->add('dexterity', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",

            ]
        ])
        ->add('intelligence', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ]
        ])
        ->add('charisma', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ]
        ])
        ->add('faith', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ]
        ])
        ->add('class', EntityType::class, [
            'class' => Classe::class,
            'choice_label' => 'nom'
        ])
        ->add('race', EntityType::class, [
            'class' => Race::class,
            'choice_label' => 'nom'
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
