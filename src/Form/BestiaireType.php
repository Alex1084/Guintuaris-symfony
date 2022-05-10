<?php

namespace App\Form;

use App\Entity\Bestiaire;
use App\Entity\TypeBestiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BestiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', EntityType::class, [
                "class" => TypeBestiaire::class,
                "choice_label" => "nom"
            ])
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

                ],
                'label' => 'Niveau'
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

                ], 
                'label' => 'Dexterité'
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
                'attr' => ['class' => 'area-form']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bestiaire::class,
        ]);
    }
}
