<?php

// src/Form/CoursType.php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomC', TextType::class, [
                'label' => 'Nom du Cours',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom du cours'],
            ])
            ->add('dureeC', IntegerType::class, [
                'label' => 'Durée (en heures)',
                'attr' => ['min' => 0, 'class' => 'form-control', 'placeholder' => 'Durée du cours'],
            ])
            ->add('periodeC', IntegerType::class, [
                'label' => 'Période',
                'attr' => [
                    'min' => 1,
                    'max' => 2,
                    'class' => 'form-control',
                    'placeholder' => '1 = Premier semestre, 2 = Second semestre',
                ],
            ])
            ->add('descriptionC', TextareaType::class, [
                'label' => 'Description du Cours',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description détaillée du cours'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
