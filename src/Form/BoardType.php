<?php

namespace App\Form;

use App\Entity\Bestiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bete', EntityType::class, [
                'mapped' => false,
                'class' => Bestiaire::class,
                'choice_label' => 'nom',
                'placeholder' => 'choisir une créature',
                'label' => 'Bestiaire'
            ]);
        $formModifier = function (Form $form, Bestiaire $bestiaire = null) {
            $tes = ($bestiaire === null) ? "salut" : "yo";
            $form->add('nom', TextType::class, [
                'data' => "yo",
                'required' => 'false'
            ]);
        };

        $builder->get('bete')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $bete = $event->getForm()->getData();
                //dump($event->getForm()->getParent());
                $formModifier($event->getForm()->getParent(), $bete);
                //$this->getDoctrine()->getRepository(Bestiaire::class)->find($beteId);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
