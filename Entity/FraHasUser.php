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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__fra_has_user")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class FraHasUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", cascade={"persist"}, inversedBy="fraHasUsers")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $fra;

    /**
     * @var Asbo\UserBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="Asbo\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @Assert\NotNull()
     */
    protected $user;

    /**
     * @var boolean $owner
     *
     * @ORM\Column(name="owner", type="boolean", nullable=true)
     */
    protected $owner;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->owner= true;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getUser().' | '.$this->getFra();
    }

    /**
     * Set owner
     *
     * @param  boolean    $owner
     * @return UserHasFra
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return boolean
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set fra
     *
     * @param  \Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return UserHasFra
     */
    public function setFra(\Asbo\WhosWhoBundle\Entity\Fra $fra)
    {
        $this->fra = $fra;

        return $this;
    }

    /**
     * Get fra
     *
     * @return \Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Set user
     *
     * @param  \Asbo\UserBundle\Entity\User $user
     * @return UserHasFra
     */
    public function setUser(\Asbo\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Asbo\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime  $updatedAt
     * @return FraHasUser
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime  $createdAt
     * @return FraHasUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Method colled when a entity is persist
     *
     * @ORM\prePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Method colled when a entity is updated
     *
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
