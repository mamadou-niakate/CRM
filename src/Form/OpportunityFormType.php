<?php

namespace App\Form;

use App\Entity\Opportunity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpportunityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('date_due')
            ->add('assigned_to')
            ->add('account')
            ->add('status')
            ->add('lead')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opportunity::class,
        ]);
    }
}
