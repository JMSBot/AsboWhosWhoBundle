<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\Email;
use Asbo\WhosWhoBundle\Form\Type\EmailType;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;

class FraAdmin extends Admin
{

    public $supportsPreviewMode = true;


    protected function configureFormFields(FormMapper $formMapper)
    {

        if ($this->hasRequest()) {
            $link_parameters = array('context' => $this->getRequest()->get('context'));
        } else {
            $link_parameters = array();
        }

        $formMapper
            ->with('Général')
            	->add('firstname')
                ->add('lastname')
                ->add('nickname')
                ->add('gender', 'choice', array('choices' => array('Homme', 'Femme')))
                ->add('bornAt', 'genemu_jquerydate', array('widget' => 'single_text','required' => false))
                ->add('bornIn')
                ->add('user')
            ->end()
            ->with('ASBO')
                ->add('anno', 'asbo_type_anno', array('help' =>  'Date de rentrée à l\'ASBO'))
                ->add('type', 'choice', array('choices' => Fra::getTypeList(), 'help' => 'Comment le membre est-il rentré à l\'ASBO ?'))
                ->add('status', 'choice', array('choices' => Fra::getStatusList(), 'help' =>  'Quel est son status actuel ?'))
                ->add('pontif', 'sonata_type_boolean', array('choices' => array('Non', 'Oui'), 'help' => 'Le Fra est/a-t\'il été pontif ?'))
            ->end()
            ->with('Autres', array('collapsed' => true))
                ->add('diedAt', 'genemu_jquerydate', array('widget' => 'single_text','required' => false))
                ->add('diedIn')
            ->end()
            ->with('Emails', array('collapsed' => true))
                ->add('emails', 'sonata_type_collection', array(), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'link_parameters' => $link_parameters
                ))
            ->end()
            ->with('Téléphones', array('collapsed' => true))
                ->add('phones', 'sonata_type_collection', array(), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
            ->end()
            ->with('Adresses', array('collapsed' => true))
                ->add('addresses', 'sonata_type_collection', array(), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
            ->end()
            ->with('Postes ASBO', array('collapsed' => true))
                ->add('posts', 'sonata_type_collection', array(), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                ))
            ->end()
            ->with('Diplôme et Etudes', array('collapsed' => true))
                ->add('diplomas', 'sonata_type_collection', array(), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
            ->end()
            ->with('Settings', array('collapsed' => true))
                ->add('settings', 'sonata_type_immutable_array', array(
                        'keys' => array(array('whoswho'              , 'checkbox', array('required' => false)),
                                        array('pereat'               , 'checkbox', array('required' => false)),
                                        array('convoc_externe'       , 'checkbox', array('required' => false)),
                                        array('convoc_banquet'       , 'checkbox', array('required' => false)),
                                        array('convoc_we'            , 'checkbox', array('required' => false)),
                                        array('convoc_ephemerides_q1', 'checkbox', array('required' => false)),
                                        array('convoc_ephemerides_q2', 'checkbox', array('required' => false))
                                        )
                        )
                    )
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstname')
                       ->add('lastname')
                       ->add('nickname')
                       ->add('anno', null, array('field_type' => 'choice', 'field_options' => array('choices' => DateToAnnoTransformer::getAnnosList())))
                       ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getTypeList())))
                       ->add('status', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getStatusList())))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('firstname')
            	   ->addIdentifier('lastname')
            	   ->addIdentifier('nickname')
                   ->add('anno', null, array('template' => 'AsboWhosWhoBundle:Admin:list_anno.html.twig'))
                   ->add('getAnnoToDates')
                   ->add('getTypeCode', 'text', array('sortable' => 'type'))
                   ->add('getStatusCode')
                   ->add('pontif', null, array('editable' => true))
                    ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array()
                    )))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('firstname')
            ->add('lastname')
            ->add('nickname')
            ->add('gender')
            ->add('bornAt')
            ->add('bornIn')
            ->add('diedAt')
            ->add('diedIn')
            ->add('anno')
            ->add('getAnnoToDates')
            ->add('getTypeCode')
            ->add('getStatusCode')
            ->add('pontif')
            ->add('settings', 'array')
        ;
    }

    public function preUpdate($entity)
    {
        $this->setFraToEntities($entity);
    }

    public function prePersist($entity)
    {
        $this->setFraToEntities($entity);
    }

    private function setFraToEntities($entity)
    {
        $emails = $entity->getEmails();
        foreach($emails as $email)
            $email->setFra($entity);

        $phones = $entity->getPhones();
        foreach ($phones as $phone)
            $phone->setFra($entity);

        $posts = $entity->getPosts();
        foreach ($posts as $post)
            $post->setFra($entity);

        $addresses = $entity->getAddresses();
        foreach ($addresses as $address)
            $address->setFra($entity);

        $diplomas = $entity->getDiplomas();
        foreach ($diplomas as $diploma)
            $diploma->setFra($entity);

    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('admin');
    }

    public function adminAction(Request $request)
    {
    }
}