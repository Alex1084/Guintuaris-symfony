<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Competence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'input-form']
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'area-form']
            ])
            ->add('niveau', IntegerType::class, [
                "attr" => [
                    "min" => 1,
                    "max" => 10,
                    "class" => "input-form",

                ]
            ])
            ->add('cout', TextType::class, [
                'attr' => ['class' => 'input-form']
            ])
            ->add('portee', TextType::class, [
                'attr' => ['class' => 'input-form']
            ])
            ->add('degat', TextType::class, [
                'attr' => ['class' => 'input-form']
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competence::class,
        ]);
    }
}
