<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Post;

class PostAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('post', 'sonata_type_model_list')
                   ->add('date', 'asbo_type_annotext', array('help' => 'Ajouter ici l\'anno s\'il s\'agit d\'un post lors d\'une année de student, sinon ajouter l\'année civile !'))
        ;

        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.post')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
                   ->addIdentifier('post')
                   ->add('date', null, array('template' => 'AsboWhosWhoBundle:Admin:list_anno.html.twig'))
        ;
    }
}
