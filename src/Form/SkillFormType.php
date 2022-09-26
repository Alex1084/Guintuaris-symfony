<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Skill;
use App\Repository\ClassesRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('cost', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Coût'
            ])
            ->add('distance', IntegerType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Portée (en mètre)',
                'required' => false,
            ])
            ->add('damage', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Dégats',
                'required' => false,
            ])
            ->add('radius', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Rayon',
                'required' => false,
            ])
            ->add('duration', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Durée',
                'required' => false,
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
