<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asbo\WhosWhoBundle\Entity\Email;

/**
 * Email type
 *
 * @todo A revoir
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class EmailType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email')
                ->add('principal', 'choice', array('required' => true, 'choices' => array('Non', 'Oui')))
                ->add('type', 'choice', array('choices' => Email::getEmailTypeList(), 'expanded' => true, 'multiple' => false));
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Asbo\WhosWhoBundle\Entity\Email'));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_email';
    }
}
