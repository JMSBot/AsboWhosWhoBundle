<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Diplome;
use Knp\Menu\ItemInterface as MenuItemInterface;

class DiplomaAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('diploma')
                   ->add('specialty')
                   ->add('institution')
                   ->add('current')
                   ->add('graduatedAt')
        ;

        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.diploma')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('diploma')
                   ->add('specialty')
                   ->add('institution')
                   ->add('current')
                   ->add('graduatedAt')
                   ->add('fra')
        ;
    }
}