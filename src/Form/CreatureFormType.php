<?php

namespace App\Form;

use App\Entity\Creature;
use App\Entity\CreatureType;
use App\Repository\CreatureTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            "label" => "Nom",
        ])
        ->add('type', EntityType::class, [
            "label" => "Type",
            "class" => CreatureType::class,
            'query_builder' => function (CreatureTypeRepository $btr) {
                return $btr->createQueryBuilder('bt')
                    ->orderBy('bt.name', 'ASC');
            },
            "choice_label" => "name"
        ])
        ->add('pvMax', IntegerType::class, [
            "attr" => [
                "min" => 1,
                "class" => "input-form",
            ],
            'label' => 'Point de vie'
        ])
        ->add('pcMax', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "class" => "input-form",
            ],
            'label' => 'Point de combat'
        ])
        ->add('pmMax', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "class" => "input-form",
            ],
            'label' => 'Point de magie'
        ])
        ->add('level', IntegerType::class, [
            "attr" => [
                "min" => 1,
                "max" => 10,
                "class" => "input-form",

            ],
            'label' => 'Niveau'
        ])
        ->add('constitution', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",

            ],
            "label" => "Constitution",
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

            ], 
            'label' => 'Dexterité'
        ])
        ->add('intelligence', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ],
            "label" => "Intelligence",
        ])
        ->add('charisma', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ], 
            'label' => 'Charisme'
        ])
        ->add('faith', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ], 
            'label' => 'Foi'
        ])
        ->add("note", TextareaType::class, [
            'attr' => ['class' => 'area-form'],
            'required' => false,
        ])
        ->add("description", TextareaType::class, [
            'attr' => ['class' => 'area-form'],
            'required' => false,
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Creature::class,
        ]);
    }
}
