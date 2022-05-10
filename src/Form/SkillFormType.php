<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Skill;
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
            ->add('distance', TextType::class, [
                'attr' => ['class' => 'input-form'],
                'label' => 'Portée',
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
