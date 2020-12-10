<?php

namespace App\Form;

use App\Entity\Interaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InteractionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created_date', DateTimeType::class,[
                'date_widget' => 'single_text',
            ])
            ->add('date_due', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('description')
            ->add('assigned_to')
            ->add('contact')
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
