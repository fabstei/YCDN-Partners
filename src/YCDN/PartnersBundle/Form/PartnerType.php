<?php

namespace YCDN\PartnersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('base')
            ->add('website')
            ->add('email')
            ->add('phone')
            ->add('description')
            ->add('file')
        ;
    }

    public function getName()
    {
        return 'ycdn_partnersbundle_partnertype';
    }
}
