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
use Asbo\UserBundle\Entity\User;

/**
 * Fra manager
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class FraManager
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
     * @param Asbo\WhosWhoBundle\Entity\Fra $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Find a fra by user
     *
     * @param  Asbo\WhosWhoBundle\Entity\User $user
     * @return Fra|DoctrineCollection|null
     */
    public function findByUser(User $user)
    {
        return $this->getRepository()->findBy(array('user' => $user));
    }

    /**
     * Find a fra by user and if the user is the fra
     *
     * @param  Asbo\WhosWhoBundle\Entity\User $user
     * @return Fra|null
     */
    public function findByUserAndOwner(User $user)
    {
        return $this->getRepository()->findBy(array('user' => $user, 'owner' => true));
    }

    /**
     * Return the repository associate to the manager
     *
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('AsboWhosWhoBundle:Fra');
    }
}
