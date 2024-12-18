<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idP', TextType::class, [
                'label' => 'ID du Projet',
            ])
            ->add('nomP', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('descriptionP', TextType::class, [
                'label' => 'Description',
            ])
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
            ])
            ->add('statuts', TextType::class, [
                'label' => 'Statut',
            ])
            ->add('pdfprojet', FileType::class, [
                'label' => 'Fichier PDF du Projet',
                'required' => false,
                'mapped' => false, // Ce champ n'est pas directement mappé à l'entité
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
