<?php

namespace App\Form;

use App\Entity\Interaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InteractionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created_date', DateType::class)
            ->add('date_due', DateType::class)
            ->add('description')
            ->add('assigned_to')
            ->add('account')
            ->add('status')
            ->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interaction::class,
        ]);
    }
}
