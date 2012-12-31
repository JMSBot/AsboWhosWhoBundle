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
use Asbo\WhosWhoBundle\Entity\Fra;

/**
 * Represent an Diploma Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__diplomas")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\DiplomaRepository")
 */
class Diploma
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
     * @var string $diploma
     *
     * @ORM\Column(name="diploma", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $diploma;

    /**
     * @var string $specialty
     *
     * @ORM\Column(name="specialty", type="string", length=50, nullable=true)
     */
    private $specialty;

    /**
     * @var string $institution
     *
     * @ORM\Column(name="institution", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $institution;

    /**
     * @var date $graduatedAt
     *
     * @ORM\Column(name="graduatedAt", type="date", nullable=true)
     */
    private $graduatedAt;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Fra
     *
     * @ORM\ManyToOne(targetEntity="Asbo\WhosWhoBundle\Entity\Fra", inversedBy="diplomas")
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
     * Set diploma
     *
     * @param string $diploma
     * @return $this
     */
    public function setDiploma($diploma)
    {
        $this->diploma = $diploma;

        return $this;
    }

    /**
     * Get diploma
     *
     * @return string
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * Set specialty
     *
     * @param string $specialty
     * @return $this
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * Get specialty
     *
     * @return string
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * Set institution
     *
     * @param string $institution
     * @return $this
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set graduatedAt
     *
     * @param date $graduatedAt
     * @return $this
     */
    public function setGraduatedAt($graduatedAt = null)
    {
        $this->graduatedAt = $graduatedAt;

        return $this;
    }

    /**
     * Get graduatedAt_fin
     *
     * @return date
     */
    public function getGraduatedAt()
    {
        return $this->graduatedAt;
    }

    /**
     * Is current
     *
     * @return boolean
     */
    public function isCurrent()
    {
        return null === $this->getGraduatedAt();
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
        return (string) $this->getDiploma().' @ '.$this->getInstitution();
    }
}
