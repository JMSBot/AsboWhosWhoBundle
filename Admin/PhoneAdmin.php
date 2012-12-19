<?php
namespace Asbo\WhosWhoBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Phone;
use Knp\Menu\ItemInterface as MenuItemInterface;

class PhoneAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('number')
                   ->add('type', 'choice', array('choices' => Phone::getTypeList(), 'expanded' => false, 'multiple' => false))
                   ->add('country', 'country')
                   ->add('principal')
        ;

        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.phone')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('number')
                       ->add('fra')
                       ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Phone::getTypeList())))
                       ->add('country', null, array('field_type' => 'country'))
                       ->add('principal')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('number')
                   ->add('getTypeCode')
                   ->add('fra')
                   ->add('getCountryCode')
                   ->add('principal')
                   ->add('_action', 'actions', array( 'actions' => array( 'unpublish' => array('template' =>'AsboWhosWhoBundle:Admin:phone_unpublish.html.twig'),)));
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('unpublish');
    }

    public function unpublishAction(Request $request)
    {
    }

}