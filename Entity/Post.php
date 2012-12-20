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
use Asbo\WhosWhoBundle\Entity\PostList;
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Represent a Post Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__posts")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\PostRepository")
 */
class Post
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
     * @var integer $anno
     *
     * @ORM\Column(name="anno", type="smallint", nullable=true)
     * @Assert\Type(type="integer")
     * @Assert\Min(limit="0")
     */
    private $anno;

    /**
     * @var date $civilyear
     *
     * @ORM\Column(name="civilyear", type="date", nullable=true)
     * @Assert\Type(type="datetime")
     */
    private $civilyear;

    /**
     * @var PostList $post
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\PostList")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $post;

    /**
     * @var Fra $fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="posts")
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
     * Set date
     *
     * @param string|\Datetime $date
     * @return $this
     * @todo Vérifier le type de la date
     */
    public function setDate($date)
    {
        if ($date instanceof \datetime) {
            $this->civilyear = $date;
            $this->anno = null;
        } else {
            $this->anno = $date;
            $this->civilyear = null;
        }

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     * @todo Vérifier le type de la date
     */
    public function getDate()
    {
        if ($this->getCivilYear() instanceof \DateTime) {
            return $this->getCivilYear()->format('Y');
        } else {
            return $this->getAnno();
        }
    }

    /**
     * Set anno
     *
     * @param integer $anno
     * @return $this
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set civilyear
     *
     * @param date $civilyear
     * @return $this
     */
    public function setCivilYear(\Datetime $civilyear)
    {
        $this->civilyear = $civilyear;

        return $this;
    }

    /**
     * Get civilyear
     *
     * @return date
     */
    public function getCivilYear()
    {
        return $this->civilyear;
    }

    /**
     * Set post
     *
     * @param Asbo\WhosWhoBundle\Entity\PostList $post
     */
    public function setPost(PostList $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Asbo\WhosWhoBundle\Entity\PostList
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set fra
     *
     * @param Asbo\WhosWhoBundle\Entity\Fra $fra
     * @return $this
     */
    public function setFra(Fra $fra)
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
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getPost();
    }
}
