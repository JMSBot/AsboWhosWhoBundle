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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represent a PostList Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__postList")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\PostListRepository")
 */
class PostList
{
    /**
     * Type Post
     */
    const TYPE_COMITE          = 0;
    const TYPE_CONSEIL         = 1;
    const TYPE_COMISSION       = 2;
    const TYPE_COMITE_VETERANS = 3;
    const TYPE_PONTIFES        = 4;
    const TYPE_FSB             = 5;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $function
     *
     * @ORM\Column(name="function", type="string", length=50)
     * @Assert\Length(min="1", max="50")
     * @Assert\NotBlank
     */
    private $function;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     * @Assert\Choice(callback = "getTypeCallbackValidation")
     */
    private $type;

    /**
     * @var integer $denier
     *
     * @ORM\Column(name="denier", type="integer")
     * @Assert\Type(type="integer")
     * @Assert\Min(limit="0")
     */
    private $denier;

    /**
     * @var string $monogramme
     *
     * @ORM\Column(name="monogramme", type="string", length=10, nullable=true)
     * @Assert\Length(min="1", max="50")
     */
    private $monogramme;

    /**
     * __toString()
     */
    public function __toString()
    {
        return $this->function;
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
     * Set function
     *
     * @param string $function
     * @return $this
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set monogramme
     *
     * @param string $monogramme
     * @return $this
     */
    public function setMonogramme($monogramme)
    {
        $this->monogramme = $monogramme;

        return $this;
    }

    /**
     * Get monogramme
     *
     * @return string
     */
    public function getMonogramme()
    {
        return $this->monogramme;
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
     * Set denier
     *
     * @param integer $dernier
     * @return $this
     */
    public function setDenier($denier)
    {
        $this->denier = $denier;

        return $this;
    }

    /**
     * Get denier
     *
     * @return integer
     */
    public function getDenier()
    {
        return $this->denier;
    }

    /**
     * Get Type List
     *
     * @return array
     */
    public static function getTypeList()
    {
        return array(
            self::TYPE_COMITE          => 'Comité',
            self::TYPE_CONSEIL         => 'Conseil',
            self::TYPE_COMISSION       => 'Comission',
            self::TYPE_COMITE_VETERANS => 'Comité des Vétérans',
            self::TYPE_PONTIFES        => 'Pontifes',
            self::TYPE_FSB             => 'Fondation Sainte Barbe',
        );
    }

    /**
     * Get Type Code
     *
     * @return string|null
     */
    public function getTypeCode()
    {
        $type = self::getTypeList();

        return isset($type[$this->getType()]) ? $type[$this->getType()] : null;
    }

    /**
     * Callback Validation
     *
     * @return array
     */
    public static function getTypeCallbackValidation()
    {
        return array_keys(self::getTypeList());
    }
}
