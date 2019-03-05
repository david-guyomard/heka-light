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
            "time_widget" => "single_text"
        )
        )
        ->add('endAt', DateTimeType::class, array(
            "date_widget" => "single_text",
            "time_widget" => "single_text"
        )
        )
        ->add('title', ChoiceType::class, array(
            "choices" => [
                "Soin energetique avec massage - 60 €" => "avec massage",
                "Soin energetique sans massage - 50 €" => "sans massage",
                "Soin energetique à distance - 30 €" => "a distance"
            ]
        ))
        ->add('userId');
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
