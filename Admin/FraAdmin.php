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
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\Email;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;
use Knp\Menu\ItemInterface as MenuItemInterface;

/**
 * Fra admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraAdmin extends Admin
{
    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Général')
                ->add('firstname')
                ->add('lastname')
                ->add('nickname')
                ->add('gender', 'choice', array('choices' => array('Homme', 'Femme')))
                ->add('bornAt', 'genemu_jquerydate', array('widget' => 'single_text','required' => false))
                ->add('bornIn')
                ->add('fraHasUsers', 'sonata_type_collection', array('required' => false), array(
                    'edit' => 'inline',
                    'inline' => 'table'
                    ))
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

            ->with('Settings', array('collapsed' => true))
                ->add(
                    'settings',
                    'sonata_type_immutable_array',
                    array('keys' => array(array('whoswho'              , 'checkbox', array('required' => false)),
                                        array('pereat'               , 'checkbox', array('required' => false)),
                                        array('convoc_externe'       , 'checkbox', array('required' => false)),
                                        array('convoc_banquet'       , 'checkbox', array('required' => false)),
                                        array('convoc_we'            , 'checkbox', array('required' => false)),
                                        array('convoc_ephemerides_q1', 'checkbox', array('required' => false)),
                                        array('convoc_ephemerides_q2', 'checkbox', array('required' => false)) ))
                )
                ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstname')
                       ->add('lastname')
                       ->add('nickname')
                       ->add('anno', null, array('field_type' => 'choice', 'field_options' => array('choices' => DateToAnnoTransformer::getAnnosList())))
                       ->add('type', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getTypeList())))
                       ->add('status', 'doctrine_orm_choice', array('field_type' => 'choice', 'field_options' => array('choices' => Fra::getStatusList())));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('firstname')
                   ->addIdentifier('lastname')
                   ->addIdentifier('nickname')
                   ->add('anno', null, array('template' => 'AsboWhosWhoBundle:Admin:list_anno.html.twig'))
                   ->add('getTypeCode', 'text', array('sortable' => 'type'))
                   ->add('getStatusCode')
                   ->add('pontif', null, array('editable' => true))
                    ->add('_action', 'actions', array('actions' => array('view' => array(), 'edit' => array(), 'delete' => array())));
    }

    /**
     * {@inheritDoc}
     */
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
            ->add('settings', 'array');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild(
            'Voir/Editer',
            array('uri' => $admin->generateUrl('edit', array('id' => $id)))
        );

        $menu->addChild(
            'Emails',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.email.list', array('id' => $id)))
        );

        $menu->addChild(
            'Téléphones',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.phone.list', array('id' => $id)))
        );

        $menu->addChild(
            'Postes ASBO',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.post.list', array('id' => $id)))
        );

        $menu->addChild(
            'Adresses',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.address.list', array('id' => $id)))
        );

        $menu->addChild(
            'Diplomes & Etudes',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.diploma.list', array('id' => $id)))
        );

        $menu->addChild(
            'Jobs',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.job.list', array('id' => $id)))
        );

        $menu->addChild(
            'Famille',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.family.list', array('id' => $id)))
        );

        $menu->addChild(
            'Postes Extérieurs',
            array('uri' => $admin->generateUrl('asbo.whoswho.admin.externalpost.list', array('id' => $id)))
        );

    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($entity)
    {
        $entity->setFraHasUsers($entity->getFraHasUsers());
        foreach ($entity->getFraHasUsers() as $relation) {
            $relation->preUpdate();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($entity)
    {
        $entity->setFraHasUsers($entity->getFraHasUsers());
    }
}
