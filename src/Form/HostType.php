<?php

namespace App\Form;

use App\Entity\Host;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class HostType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip',TextType::class)
            ->add('mac',TextType::class)
            ->add('nom',TextType::class)
            ->add('location',TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'up' => 'up',
                    'down' => 'down',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Host::class,
        ]);
    }
}
