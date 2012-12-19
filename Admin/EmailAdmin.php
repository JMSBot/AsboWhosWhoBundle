<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Asbo\WhosWhoBundle\Entity\EmailManager;
use Asbo\WhosWhoBundle\Entity\Email;
use Asbo\WhosWhoBundle\Form\EmailAdminType;
use Knp\Menu\ItemInterface as MenuItemInterface;

class EmailAdmin extends Admin
{
    protected $emailManager;

    protected $translationDomain = 'AsboWhosWhoBundle';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('email')
                   ->add('principal', 'sonata_type_boolean')
                   ->add('type', 'choice', array('choices' => Email::getEmailTypeList(), 'expanded' => true, 'multiple' => false))
        ;

        if($this->getRequest()->get('_sonata_admin') === 'asbo.whoswho.admin.fra.email')
            $formMapper->add('fra', 'sonata_type_model_list');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fra')
                       ->add('email')
                       ->add('principal')
                       ->add('type', null, array('field_type' => 'choice',
                                                 'field_options' => array('choices' => Email::getEmailTypeList())))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('email')
                   ->add('fra')
                   ->add('getTypeCode', 'text', array('label' => 'Type', 'sortable' => 'Type'))
                   ->add('principal')
        ;
    }

    public function validate(ErrorElement $errorElement, $email)
    {
        if(!$email->isPrincipal())
        {
            $emailManager = $this->getEmailManager();
            $emails       = $emailManager->findByFraAndPrincipal($email);

            if(empty($emails) || $emails[0]->getId() === $email->getId())
            {
                $errorElement
                    ->with('principal')
                        ->addViolation($this->trans('error.1', array(), 'AsboWhosWhoBundle'))
                    ->end()
                ;
            }
        }
    }

    protected function getEmailTypeList()
    {
        return array_combine(array_values(Email::getEmailTypeList()), array_values(Email::getEmailTypeList()));
    }

    public function setEmailManager(EmailManager $emailManager)
    {
        $this->emailManager = $emailManager;
    }

    public function getEmailManager()
    {
        return $this->emailManager;
    }

    public function preRemove($email)
    {
        if($email->isPrincipal())
            $this->getEmailManager()->setRandomPrincipal($email);
    }

    public function preUpdate($email)
    {
        $this->setPrincipalEmail($email);
    }

    public function prePersist($email)
    {
        $this->setPrincipalEmail($email);
    }

    private function setPrincipalEmail($email)
    {
        if($email->isPrincipal())
            $this->getEmailManager()->setPrincipalEmail($email);
    }

}