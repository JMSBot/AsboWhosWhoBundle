<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\PostList;
use Knp\Menu\ItemInterface as MenuItemInterface;

class PostListAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('function')
                   ->add('type', 'choice', array('choices' => PostList::getTypeList(), 'expanded' => true))
                   ->add('denier')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => PostList::getTypeList())))
                       ->add('denier')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('function')
                   ->add('getTypeCode')
                   ->add('denier');
        ;
    }
}