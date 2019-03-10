<?php

namespace Application\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Application\AppBundle\Entity\User;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('beginAt', DateTimeType::class, array(
            "date_widget" => "single_text",
            "time_widget" => "choice",
            "hours" => range(9,18),
            "minutes" => range(0,59,15)
        )
        )
        ->add('title', ChoiceType::class, array(
            "choices" => [
                "Soin energetique avec massage 1h - 60 €" => "Soin energetique avec massage",
                "Soin energetique sans massage 1h - 50 €" => "Soin energetique sans massage",
                "Soin energetique à distance 1h - 30 €" => "Soin energetique à distance"
            ]
        ))
        ->add('userId')
        ->add('address');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\AppBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'application_appbundle_booking';
    }


}
