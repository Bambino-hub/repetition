<?php

namespace App\Form;

use App\Entity\Days;
use App\Entity\User;
use App\Entity\Level;
use App\Entity\Matter;
use App\Entity\TimeTable;
use App\Entity\WorkSpace;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WorkSpaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', EntityType::class, [
                'label' => 'Votre niveau actuel',
                'class' => Level::class,
                'choice_label' => 'name',
                'expanded' => true,

            ])

            ->add('matters', EntityType::class, [
                'label'  =>   'Les matières dans lesquelles vous souhaitez travailler',
                'class' => Matter::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false

            ])
            ->add('days', EntityType::class, [
                'label'  =>   'Jour de travail',
                'class' => Days::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false

            ])
            ->add('timeTables', EntityType::class, [
                'label'  => 'horaires',
                'class' => TimeTable::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkSpace::class,
        ]);
    }
}