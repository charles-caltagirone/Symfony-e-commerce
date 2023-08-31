<?php

namespace App\Form;

use App\Entity\Adresses;
use App\Entity\Carrier;
use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('adress', EntityType::class, [
                'class' => Adresses::class,
                'label' => "Choisir l'adresse de livraison :",
                'choices' => $user->getAdresses(),
                'expanded' => true,
                'multiple' => false,
                ])
                ->add('carrier', EntityType::class, [
                    'class' => Carrier::class,
                    'label' => "Choisir l'expéditeur :",
                    'expanded' => true,
                    'multiple' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array(),
        ]);
    }
}
