<?php
namespace Asbo\WhosWhoBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Address;
use Knp\Menu\ItemInterface as MenuItemInterface;

class AddressAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('address', 'gmap_address', array('data_class' => 'Asbo\WhosWhoBundle\Entity\Address'))
                   ->add('type', 'choice', array('choices' => Address::getTypeList(), 'expanded' => false, 'multiple' => false))
                   ->add('principal')
        ;

        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.address')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fra')
                       ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Address::getTypeList())))
                       ->add('principal')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('address')
                   ->add('TypeCode')
                   ->add('fra')
                   ->add('principal')
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AsboWhosWhoBundle:Admin:address_edit.html.twig';
                break;
            case 'create':
                return 'AsboWhosWhoBundle:Admin:address_create.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}