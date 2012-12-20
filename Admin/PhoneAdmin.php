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
use Asbo\WhosWhoBundle\Entity\Phone;

/**
 * Phone admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class PhoneAdmin extends Admin
{

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('number')
                   ->add('type', 'choice', array('choices' => Phone::getTypeList(), 'expanded' => false, 'multiple' => false))
                   ->add('country', 'country')
                   ->add('principal');

        if ($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.phone') {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('number')
                       ->add('fra')
                       ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Phone::getTypeList())))
                       ->add('country', null, array('field_type' => 'country'))
                       ->add('principal');
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('number')
                   ->add('getTypeCode')
                   ->add('fra')
                   ->add('getCountryCode')
                   ->add('principal')
                   ->add('_action', 'actions', array('actions' => array('unpublish' => array('template' =>'AsboWhosWhoBundle:Admin:phone_unpublish.html.twig'))));
    }
}
