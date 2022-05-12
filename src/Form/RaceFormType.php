<?php

namespace App\Form;

use App\Entity\Race;
use Symfony\Component\Form\AbstractType;
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
            ->add('ability', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Aptitude'
            ])
            ->add('bonus', TextareaType::class, [
                'attr' => ['class' => 'area-form'],
                'label' => 'Bonus'
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
