<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Diploma admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class DiplomaAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected $parentAssociationMapping = 'fra';

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('diploma')
                   ->add('specialty')
                   ->add('institution')
                   ->add('graduatedAt');

        if (!$this->isChild()) {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('diploma')
                   ->add('specialty')
                   ->add('institution')
                   ->add('graduatedAt')
        if (!$this->isChild()) {
            $listMapper->add('fra', 'sonata_type_model_list');
        }
    }
}
