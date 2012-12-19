<?php

namespace Asbo\WhosWhoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asbo\WhosWhoBundle\Entity\Fra;

class FraType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname')
                ->add('lastname')
                ->add('nickname')
                ->add('gender', 'choice', array('choices' => array('Homme', 'Femme')))
                ->add('lastname')
                ->add('bornAt')
                ->add('diedAt')
                ->add('bornIn')
                ->add('diedIn')
                ->add('type')
                ->add('status')
                ->add('anno')
                ->add('pontif')
                ->add('user')
                ->add('settings')
                ->add('emails', 'collection', array('type' => new EmailType(), 'prototype' => true, 'allow_add' => true, 'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Asbo\WhosWhoBundle\Entity\Fra'
        ));
    }

    public function getName()
    {
        return 'asbo_whoswhobundle_fratype';
    }
}
