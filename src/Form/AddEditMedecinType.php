<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Hopital;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEditMedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Naissance',
            ])
            ->add('hopital', EntityType::class, [
                'class' => Hopital::class,
                'choice_label' => 'nom',
                'label' => 'Hopital',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}