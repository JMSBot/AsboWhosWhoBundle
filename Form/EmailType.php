<?php

namespace Asbo\WhosWhoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Asbo\WhosWhoBundle\Entity\Email;

class EmailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email')
                   ->add('principal', 'choice', array('required' => true, 'choices' => array('Non', 'Oui')))
                   ->add('type', 'choice', array('choices' => Email::getEmailTypeList(), 'expanded' => true, 'multiple' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Asbo\WhosWhoBundle\Entity\Email'
        ));
    }

    public function getName()
    {
        return 'asbo_whoswhobundle_emailtype';
    }
}
