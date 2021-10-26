<?php

namespace App\Form;

use App\Entity\Bestiaire;
use App\Entity\TypeBestiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BestiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('niveau')
            ->add('Type', EntityType::class, [
                "class" => TypeBestiaire::class,
                "choice_label" => "nom"
            ])
            ->add('pv')
            ->add('pvMax')
            ->add('pc')
            ->add('pcMax')
            ->add('pm')
            ->add('pmMax')
            ->add('constitution')
            ->add('laForce')
            ->add('dexterite')
            ->add('intelligence')
            ->add('charisme')
            ->add('foi')
            ->add("note");
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bestiaire::class,
        ]);
    }
}
