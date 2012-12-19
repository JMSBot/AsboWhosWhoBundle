<?php

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\EntityManager;
use Asbo\WhosWhoBundle\Entity\Email;

class EmailManager
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function setPrincipalEmail(Email $email)
    {
        $emails = $this->getRepository()->findBy(array('fra' => $email->getFra(), 'principal' => true));

        foreach ($emails as $oldEmail) {
            if($oldEmail->isPrincipal() && $email->getId() !== $oldEmail->getId())
                $this->em->persist($oldEmail->setPrincipal(false));
        }

        $this->em->flush();
    }

    public function findByFraAndPrincipal(Email $email)
    {
        return $this->getRepository()->findBy(array('fra' => $email->getFra(), 'principal' => true));
    }

    public function setRandomPrincipal(Email $oldEmail)
    {
        $email = $this->getRepository()->findOneBy(array('fra' => $oldEmail->getFra()));

        if(!empty($email)) {
            $email->setPrincipal(true);
            $this->persistAndFlush($email);
        }
    }

    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:Email');
    }

}