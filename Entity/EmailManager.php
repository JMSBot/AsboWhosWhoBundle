<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\EntityManager;
use Asbo\WhosWhoBundle\Entity\Email;

/**
 * Email manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class EmailManager
{
    /**
     * Entity Manager
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Persist and flush automaticly the entity
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Set the email to principal email
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $email
     */
    public function setPrincipalEmail(Email $email)
    {
        $emails = $this->getRepository()->findBy(array('fra' => $email->getFra(), 'principal' => true));

        foreach ($emails as $oldEmail) {
            if ($oldEmail->isPrincipal() && $email->getId() !== $oldEmail->getId()) {
                $this->em->persist($oldEmail->setPrincipal(false));
            }
        }

        $this->em->flush();
    }

    /**
     * Find an email by fra and if it's principal email
     *
     * @param  Asbo\WhosWhoBundle\Entity\Email $email
     * @return Email|null
     * @todo  Vérifier ce que renvoie la fonction si rien n'est récupéré en base de donnée
     */
    public function findByFraAndPrincipal(Email $email)
    {
        return $this->getRepository()->findBy(array('fra' => $email->getFra(), 'principal' => true));
    }

    /**
     * Set an email randomly to principal email
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $oldEmail
     */
    public function setRandomPrincipal(Email $oldEmail)
    {
        $email = $this->getRepository()->findOneBy(array('fra' => $oldEmail->getFra()));

        if (!empty($email)) {
            $email->setPrincipal(true);
            $this->persistAndFlush($email);
        }
    }

    /**
     * Return the repository associate to the manager
     *
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:Email');
    }
}
