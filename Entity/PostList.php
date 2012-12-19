<?php

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asbo\WhosWhoBundle\Entity\PostList
 *
 * @ORM\Table(name="ww__postList")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\PostListRepository")
 */
class PostList
{
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
     * @var string $type
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
     * Type Post
     */
    const TYPE_COMITE          = 0;
    const TYPE_CONSEIL         = 1;
    const TYPE_COMISSION       = 2;
    const TYPE_COMITE_VETERANS = 3;
    const TYPE_PONTIFES        = 4;
    const TYPE_FSB             = 5;

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
     * Set type
     *
     * @param string $type
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
     * @return string
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
