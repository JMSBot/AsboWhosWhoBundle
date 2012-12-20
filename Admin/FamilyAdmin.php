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
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Family;

/**
 * Family admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FamilyAdmin extends Admin
{
    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('lastname')
                   ->add('firstname')
                   ->add('date')
                   ->add('type', 'choice', array('choices' => Family::getTypeList(), 'expanded' => true, 'multiple' => false))
                   ->add('link', null, array('required' => false));

        if ($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.family') {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstname')
                       ->add('lastname')
                       ->add('fra')
                       ->add('link');
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('lastname')
                   ->add('firstname')
                   ->add('date')
                   ->add('getTypeCode')
                   ->add('link')
                   ->add('fra');
    }
}
