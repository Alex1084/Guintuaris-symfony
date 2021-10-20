<?php

namespace App\Form;

use App\Entity\Bestiaire;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bestiaire::class,
        ]);
    }
}
