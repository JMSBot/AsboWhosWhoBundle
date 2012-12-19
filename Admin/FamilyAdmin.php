<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Family;
use Knp\Menu\ItemInterface as MenuItemInterface;

class FamilyAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('lastname')
                   ->add('firstname')
                   ->add('date')
                   ->add('type', 'choice', array('choices' => Family::getTypeList(), 'expanded' => true, 'multiple' => false))
                   ->add('link', null, array('required' => false))
        ;
        
        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.family')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstname')
                       ->add('lastname')
                       ->add('fra')
                       ->add('link')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('lastname')
                   ->add('firstname')
                   ->add('date')
                   ->add('getTypeCode')
                   ->add('link')
                   ->add('fra')
        ;
    }
}