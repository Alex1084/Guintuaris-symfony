<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Classes;
use App\Entity\Race;
use App\Repository\ClassesRepository;
use App\Repository\RaceRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            "label" => "Nom"
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
            "label" => "Niveau",
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
            "label" => "Dextérité",
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
            "label" => "Charisme",
        ])
        ->add('faith', IntegerType::class, [
            "attr" => [
                "min" => 0,
                "max" => 85,
                "class" => "input-form",
            ],
            "label" => "Foi",
        ])
        ->add('class', EntityType::class, [
            'class' => Classes::class,
            'query_builder' => function (ClassesRepository $cr) {
                return $cr->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            },
            'choice_label' => 'name',
            'invalid_message' => "Erreur, la valeur sélectionnée n'est pas valides.",
            "label" => "Classe",
        ])
        ->add('race', EntityType::class, [
            'class' => Race::class,
            'query_builder' => function (RaceRepository $rr) {
                return $rr->createQueryBuilder('r')
                    ->orderBy('r.name', 'ASC');
            },
            'choice_label' => 'name',
            'invalid_message' => "Erreur, la valeur sélectionnée n'est pas valides.",
            "label" => "Race",
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
