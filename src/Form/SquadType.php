<?php

namespace App\Form;


use App\Entity\Activity;
use App\Entity\User;
use App\Entity\Squad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SquadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class,
                ['label' => 'Nom']
            )

            ->add('members', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'label' => 'Membres à ajouter',
                'placeholder' => 'Choisissez une option',
                'choice_label' => 'nom',
            ])

            ->add('activities', EntityType::class, [
                'class' => Activity::class,
                'multiple' => true,
                'label' => 'Activités',
                'placeholder' => 'Choisissez une option',
                'choice_label' => 'name',

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
