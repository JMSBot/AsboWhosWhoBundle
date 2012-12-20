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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;

/**
 * Anno type
 *
 * @todo A revoir
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AnnoType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('invalid_message' => 'Cette ANNO n\'existe pas !', 'choices' => DateToAnnoTransformer::getAnnosList()));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'asbo_type_anno';
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'choice';
    }
}
