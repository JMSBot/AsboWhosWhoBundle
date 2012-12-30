<?php

namespace Asbo\WhosWhoBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DateRangeType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         if ($options['format']) {
            $options['dateBegin']['format'] = $options['format'];
            $options['dateEnd']['format']   = $options['format'];
         }

         $builder
               ->add('dateBegin', new DateType(), $options['dateBegin'])
               ->add('dateEnd', new DateType(), $options['dateEnd']);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        $years = range(date('Y'), date('Y') - 120);

        return array(
            'format'    => null,
            'years'     => $years,
            'days'      => null,
            'months'    => null,
            'dateBegin' => array('years' => $years, 'widget' => 'choice', 'required' => true),
            'dateEnd'   => array('years' => $years, 'widget' => 'choice', 'empty_value' => '', 'required' => false),
            'widget'    => 'choice',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date_range';
    }
}
