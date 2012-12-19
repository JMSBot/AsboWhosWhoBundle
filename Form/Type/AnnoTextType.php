<?php

namespace Asbo\WhosWhoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asbo\WhosWhoBundle\Form\DataTransformer\StringToAnnoTransformer;

class AnnoTextType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array('choices' => array('Anno', 'Année Civil')))
                ->add('date', 'text')
                ->addViewTransformer(new StringToAnnoTransformer());;
    }

    public function getName()
    {
        return 'asbo_type_annotext';
    }

}
