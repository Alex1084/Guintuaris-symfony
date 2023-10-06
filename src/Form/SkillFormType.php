<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\DurationType;
use App\Entity\Resource;
use App\Entity\Skill;
use App\Entity\Statistic;
use App\Repository\ClassesRepository;
use App\Repository\DurationTypeRepository;
use App\Repository\ResourceRepository;
use App\Repository\StatisticRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Nom'
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Description'
            ])
            ->add('level', IntegerType::class, [
                "attr" => [
                    "min" => 1,
                    "max" => 10,
                    "class" => "input-form",

                ],
                'label' => 'Niveau'
            ])
            ->add('experience', IntegerType::class, [
                "attr" => [
                    "class" => "input-form"
                ],
                'label' => "Experience"
            ])
            ->add('cost', IntegerType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Coût'
            ])
            ->add('resource', EntityType::class, [
                'label' => "Ressource",
                'class' => Resource::class,
                'query_builder' => function (ResourceRepository $rr) {
                    return $rr->createQueryBuilder('r')
                        ->orderBy('r.label', 'ASC');
                },
            ])
            ->add('diceThrow', EntityType::class, [
                'label' => "Jet",
                'class' => Statistic::class,
                'query_builder' => function (StatisticRepository $sr) {
                    return $sr->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                "choice_label" => "name"
            ])
            ->add('distance', NumberType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Portée (en mètre)',
                'required' => false,
            ])
            ->add('damage', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dégats',
                'required' => false,
            ])
            ->add('radius', NumberType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Rayon',
                'required' => false,
            ])
            ->add('duration', IntegerType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Durée',
                'required' => false,
            ])
            ->add('durationType', EntityType::class, [
                'label' => "Type de durèe",
                'class' => DurationType::class,
                'query_builder' => function (DurationTypeRepository $dtr) {
                    return $dtr->createQueryBuilder('dt')
                        ->orderBy('dt.label', 'ASC');
                },
                "choice_label" => "label"
            ])
            ->add('class', EntityType::class, [
                'class' => Classes::class,
                'query_builder' => function (ClassesRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Classe'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
