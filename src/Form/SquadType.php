<?php

namespace App\Form;


use App\Entity\User;
use App\Entity\Squad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SquadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name')
            ->add('members', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'placeholder' => '-- Choisir les membres à ajouter --',
                'label' => 'Membres',
                'multiple' => true,
                'class' => User::class,
                'choice_label' => 'prenom',

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
