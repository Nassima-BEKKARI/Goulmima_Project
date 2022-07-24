<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateArrivee', DateType::class,[
                 'widget'=>'single_text'
            ])
            ->add('dateDepart', DateType::class,[
                 'widget'=>'single_text'
            ])
            ->add('Chambre', EntityType::class,[
                'class'=>Chambre::class,
                'choice_label'=>'nom',
                'placeholder'=>"choisissez une chambre",
                'mapped' => false,
                // 'allow_add' => true
            ])
            ->add('reserver', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
