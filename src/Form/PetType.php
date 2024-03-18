<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Creature;
use App\Entity\Character;
use App\Repository\CreatureRepository;
use App\Repository\CharacterRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom"
            ])
            ->add('owner', EntityType::class, [
                'class' => Character::class,
                'query_builder' => function (CharacterRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('species', EntityType::class, [
                'class' => Creature::class,
                'query_builder' => function (CreatureRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                }
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }
}
