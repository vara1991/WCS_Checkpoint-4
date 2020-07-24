<?php

namespace App\Form;

use App\Entity\Spectator;
use App\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpectatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, ['label' => 'Prénom'])
            ->add('lastname',TextType::class, ['label' => 'Nom'])
            ->add('booking', EntityType::class, [
                'class' => Booking::class,
                'choice_label' => 'getStartFormat',
                'label' => 'RDV'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spectator::class,
        ]);
    }
}
