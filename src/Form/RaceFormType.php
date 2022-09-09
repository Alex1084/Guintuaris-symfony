<?php

namespace App\Form;

use App\Entity\Race;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceFormType extends AbstractType
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
            ->add('physicalAbility', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Aptitude physique'
            ])
            ->add('socialAbility', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Aptitude sociale'
            ])
            ->add('bonus', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Bonus'
            ])
            ->add('minHieght', IntegerType::class, [
                'label' => 'Taille minimum (en cm)',
                'attr' => ['class' => "input-form"]
            ])
            ->add('maxHeight', IntegerType::class, [
                'label' => 'Taille maximum (en cm)',
                'attr' => ['class' => "input-form"]
            ])
            ->add('averageWheight', IntegerType::class, [
                'label' => 'Poids moyen (en kg)',
                'attr' => ['class' => "input-form"]
            ])
            ->add('adulthood', IntegerType::class, [
                'label' => 'Age adulte',
                'attr' => ['class' => "input-form"]
            ])
            ->add('lifetime', IntegerType::class, [
                'label' => 'Durée de vie',
                'attr' => ['class' => "input-form"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
