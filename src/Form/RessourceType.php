<?php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeR', ChoiceType::class, [
                'choices' => [
                    'TD' => 'TD',
                    'TP' => 'TP',
                    'Cour' => 'Cour',
                ],
                'expanded' => false,  // false pour une liste déroulante (pas de boutons radio)
                'multiple' => false, // Un seul choix possible
                'label' => 'Type de ressource',
            ])
            ->add('nomR', TextType::class)
            ->add('fileR', TextareaType::class)
            ->add('dureeR', ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                ],
                'expanded' => false,  // false pour une liste déroulante
                'multiple' => false, // Un seul choix possible
                'label' => 'Durée (en heures)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
