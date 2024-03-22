<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\Creature;
use App\Entity\Character;
use App\Repository\CreatureRepository;
use App\Repository\CharacterRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PetType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom"
            ])
            ->add('owner', EntityType::class, [
                'label' => "Maître",
                'class' => Character::class,
                'choice_label' => 'name',
                'query_builder' => function (CharacterRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                    ->where('c.user = :player')
                    ->setParameter("player", $this->security->getUser())
                    ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('species', EntityType::class, [
                "label" => "Créature",
                'choice_label' => 'name',
                'class' => Creature::class,
                'placeholder' => 'choisisser une créature',
                'query_builder' => function (CreatureRepository $cr)
                {
                    return $cr->createQueryBuilder('c')
                    ->where('c.tameable = 1')
                    ->orderBy('c.name', 'ASC');
                },
                'choice_attr' => ChoiceList::attr($this, function (?Creature $creature) {
                    return $creature ? ['data-infos' => \json_encode($creature->getInfos())] : [];
                })
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

            ->add('physicalAbsorption', IntegerType::class, [
                "attr" => [
                    "min" => 0,
                    "class" => "input-form",
                ],
                'label' => 'Resistance physique'
            ])
            ->add('magicalAbsorption', IntegerType::class, [
                "attr" => [
                    "min" => 0,
                    "class" => "input-form",
                ],
                'label' => 'Resistance magique'
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
