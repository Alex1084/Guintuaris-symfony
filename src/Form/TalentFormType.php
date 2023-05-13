<?php

namespace App\Form;

use App\Entity\Talent;
use App\Entity\Statistic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TalentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "attr" => ["class" => "input-form"]
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                "attr" => ["class" => "area-form"] 
            ])
            ->add('statistic', EntityType::class, [
                'class' => Statistic::class,
                'choice_label' => 'name',
                'label' => 'Statistque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Talent::class,
        ]);
    }
}
