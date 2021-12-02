<?php

namespace App\Form;

use App\Entity\Panne;
use App\Entity\Host;
use App\Entity\Technicien;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_panne',DateType::class)
            ->add('date_reparation',DateType::class)
            ->add('type',TextType::class)
            ->add('description',TextType::class)
            ->add('host',EntityType::class, [
                'class' => Host::class,
                'choice_label' => 'ip',
            ])
            ->add('technicien',EntityType::class,[
                'class' => Technicien::class,
                'choice_label' => 'nom',
            ])
            
            ->add('save', SubmitType::class, ['label' => 'add panne']) ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Panne::class,
        ]);
    }
}
