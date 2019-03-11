<?php

namespace Application\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Application\AppBundle\Entity\Booking;

class BookingType extends AbstractType
{
    private $translator;
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface    $tokenStorage
     */
    public function __construct(TranslatorInterface $translator, TokenStorageInterface $tokenStorage)
    {
        $this->translator = $translator;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $username = $user->getusername();
        $builder->add('beginAt', DateTimeType::class, array(
            "date_widget" => "single_text",
            "time_widget" => "choice",
            "hours" => range(9,18),
            "minutes" => range(0,59,15),
            "required"=>true,
        )
        )
        ->add('title', ChoiceType::class, array(
            "choices" => [
                "soin.with_massage"=> $this->translator->trans('soin.with_massage'),
                "soin.without_massage"=> $this->translator->trans('soin.without_massage'),
                "soin.distance"=> $this->translator->trans('soin.distance'),
            ],
            'translation_domain' => 'soin',
            
            "required"=>true,
        ))
        ->add('userId', ChoiceType::class, array(
            "choices"=> [
                $username => $username
            ],
            "required"=>true,
        ))
        ->add('address', 'text', array(
            "required"=>true,
        ));
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
