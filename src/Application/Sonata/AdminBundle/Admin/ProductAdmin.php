<?php

namespace Application\Sonata\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use A2lix\AutoFormBundle\Form\Type\AutoFormType;
use A2lix\TranslationFormBundle\Form\Type\TranslatedEntityType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        //$formMapper->add('id', TextType::class);
        $formMapper->add('translations', TranslationsType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', TextType::class);
        $listMapper->addIdentifier('translations', TranslatedEntityType::class, array("label"=>"titre"));
    }
}