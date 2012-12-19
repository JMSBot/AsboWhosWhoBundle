<?php

namespace Asbo\WhosWhoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;

class AnnoType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'Cette ANNO n\'existe pas !',
            'choices' => DateToAnnoTransformer::getAnnosList(),
        ));
    }

    public function getName()
    {
        return 'asbo_type_anno';
    }

    public function getParent()
    {
        return 'choice';
    }
}
