<?php

namespace App\Form;


use App\Entity\User;
use App\Entity\Squad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SquadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class,
                ['label' => 'nom']
            )

            ->add('members', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'label' => 'Membres à ajouter',
                'placeholder' => 'Choisissez une option',
                'choice_label' => 'prenom',
            ])

            ->add('Enregistrer', SubmitType::class, [
                'label' => 'Créer la Squad '
            ])
        ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Squad::class,
        ]);
    }
}
