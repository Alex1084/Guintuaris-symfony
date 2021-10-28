<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Personnage;
use App\Entity\Race;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
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
            ->add('niveau', IntegerType::class, [
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
            ->add('laForce', IntegerType::class, [
                "attr" => [
                    "min" => 0,
                    "max" => 85,
                    "class" => "input-form",

                ],
                'label' => 'Force'
            ])
            ->add('dexterite', IntegerType::class, [
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
            ->add('charisme', IntegerType::class, [
                "attr" => [
                    "min" => 0,
                    "max" => 85,
                    "class" => "input-form",
                ]
            ])
            ->add('foi', IntegerType::class, [
                "attr" => [
                    "min" => 0,
                    "max" => 85,
                    "class" => "input-form",
                ]
            ])
            ->add('lore')
            ->add('inventaire')
            ->add('po')
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom'
            ])
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'nom'
            ])
            ->add('joueur')
            /*
            ->add('equipe') */;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
