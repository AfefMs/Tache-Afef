<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idT', IntegerType::class, ['label' => 'ID de la tâche'])
            ->add('nomT', TextType::class, ['label' => 'Nom'])
            ->add('descriptionT', TextType::class, ['label' => 'Description'])
            ->add('dateDebut', DateTimeType::class, ['widget' => 'single_text', 'label' => 'Date de début'])
            ->add('dateFin', DateTimeType::class, ['widget' => 'single_text', 'label' => 'Date de fin'])
            ->add('statusT', TextType::class, ['label' => 'Statut'])
            ->add('PrjetT', TextType::class, ['label' => 'Projet associé']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
