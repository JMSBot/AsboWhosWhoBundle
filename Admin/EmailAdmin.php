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
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\EmailManager;
use Asbo\WhosWhoBundle\Entity\Email;

/**
 * Email admin for SonataAdminBundle
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class EmailAdmin extends Admin
{
    /**
     * @var Asbo\WhosWhoBundle\Entity\EmailManager
     */
    protected $emailManager;

    /**
     * {@inheritDoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('email')
                   ->add('principal', 'sonata_type_boolean')
                   ->add('type', 'choice', array('choices' => Email::getEmailTypeList(), 'expanded' => true, 'multiple' => false));

        if ($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.email') {
            $formMapper->add('fra', 'sonata_type_model_list');
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fra')
                       ->add('email')
                       ->add('principal')
                       ->add('type', null, array('field_type' => 'choice', 'field_options' => array('choices' => Email::getEmailTypeList())));
    }

    /**
     * {@inheritDoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('email')
                   ->add('fra')
                   ->add('getTypeCode', 'text', array('label' => 'Type', 'sortable' => 'Type'))
                   ->add('principal');
    }

    /**
     * {@inheritDoc}
     */
    public function validate(ErrorElement $errorElement, $email)
    {
        if (!$email->isPrincipal()) {
            $emailManager = $this->getEmailManager();
            $emails       = $emailManager->findByFraAndPrincipal($email);

            if (empty($emails) || $emails[0]->getId() === $email->getId()) {
                $errorElement->with('principal')
                                ->addViolation($this->trans('error.1', array(), 'AsboWhosWhoBundle'))
                             ->end();
            }
        }
    }

    /**
     * Get email type list
     *
     * @return array
     */
    protected function getEmailTypeList()
    {
        return array_combine(array_values(Email::getEmailTypeList()), array_values(Email::getEmailTypeList()));
    }

    /**
     * Set email manager
     *
     * @param Asbo\WhosWhoBundle\Entity\EmailManager $emailManager
     */
    public function setEmailManager(EmailManager $emailManager)
    {
        $this->emailManager = $emailManager;
    }

    /**
     * Return email manager
     *
     * @return Asbo\WhosWhoBundle\Entity\EmailManager
     */
    public function getEmailManager()
    {
        return $this->emailManager;
    }

    /**
     * Turn principal property to true
     *
     * @param Asbo/WhosWhoBundle/Entity/Email $email
     */
    private function setPrincipalEmail(Email $email)
    {
        if ($email->isPrincipal()) {
            $this->getEmailManager()->setPrincipalEmail($email);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function preRemove($email)
    {
        if ($email->isPrincipal()) {
            $this->getEmailManager()->setRandomPrincipal($email);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($email)
    {
        $this->setPrincipalEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($email)
    {
        $this->setPrincipalEmail($email);
    }
}
