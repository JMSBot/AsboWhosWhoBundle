<?php

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Locale\Locale;
use Asbo\CoreBundle\Entity\AbstractGMapEntity;

/**
 * Asbo\WhosWhoBundle\Entity\Address
 *
 * @ORM\Table(name="ww__addresss")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\AddressRepository")
 */
class Address extends AbstractGMapEntity
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
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getTypeCallbackValidation")
     */
    private $type;

    const TYPE_PRIVEE  = 0;
    const TYPE_KOT     = 1;
    const TYPE_PARENTS = 2;
    const TYPE_BOULOT  = 3;
    const TYPE_AUTRE   = 4;

    /**
     * @var boolean $principal
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     * @Assert\Type(type="bool")
     */
    private $principal;

    /**
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fra;

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
     * Set type
     *
     * @param integer $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     * @return $this
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }

    /**
     * Get principal
     *
     * @return boolean
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set fra
     *
     * @param Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return $this
     */
    public function setFra(\Asbo\WhosWhoBundle\Entity\Fra $fra)
    {
        $this->fra = $fra;
        return $this;
    }

    /**
     * Get fra
     *
     * @return Asbo\WhosWhoBundle\Entity\Fra
     */
    public function getFra()
    {
        return $this->fra;
    }

    /**
     * Is Princpal Adress
     */
    public function isPrincipal()
    {
        return true === $this->principal;
    }

    /**
     * Get TypeList
     */
    public static function getTypeList()
    {
        return array(
            self::TYPE_PRIVEE  => 'Privée',
            self::TYPE_KOT     => 'Kot',
            self::TYPE_PARENTS => 'Parents',
            self::TYPE_BOULOT  => 'Boulot',
            self::TYPE_AUTRE   => 'Autre',
        );
    }

    /**
     * Get Type Code
     */
    public function getTypeCode()
    {
        $type = self::getTypeList();

        return isset($type[$this->getType()]) ? $type[$this->getType()] : null;
    }

    /**
     * Callback Validation
     */
    public static function getTypeCallbackValidation()
    {
        return array_keys(self::getTypeList());
    }

}