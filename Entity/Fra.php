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
use Gedmo\Mapping\Annotation as Gedmo;
use Asbo\UserBundle\Entity\User;
use Asbo\WhosWhoBundle\Entity\Fra;
use Asbo\WhosWhoBundle\Entity\Email;
use Asbo\WhosWhoBundle\Entity\Diploma;
use Asbo\WhosWhoBundle\Entity\Post;
use Asbo\WhosWhoBundle\Entity\Phone;
use Asbo\WhosWhoBundle\Entity\Address;
use Asbo\WhosWhoBundle\Entity\Job;
use Asbo\WhosWhoBundle\Entity\ExternalPost;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;

/**
 * Represent a Fra Entity
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 *
 * @ORM\Table(name="ww__fras")
 * @ORM\Entity(repositoryClass="Asbo\WhosWhoBundle\Entity\FraRepository")
 */
class Fra
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
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\MaxLength(50)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\MaxLength(50)
     */
    private $lastname;

    /**
     * @var string $nickname
     *
     * @ORM\Column(name="nickname", type="string", length=50, nullable=true)
     * @Assert\MaxLength(50)
     */
    private $nickname;

    /**
     * @var boolean $gender
     *
     * @ORM\Column(name="gender", type="boolean")
     * @Assert\choice({0, 1})
     */
    private $gender;

    /**
     * @var \DateTime $bornAt
     *
     * @ORM\Column(name="bornAt", type="date", nullable=true)
     * @Assert\date
     */
    private $bornAt;

    /**
     * @var \DateTime $diedAt
     *
     * @ORM\Column(name="diedAt", type="date", nullable=true)
     * @Assert\date
     */
    private $diedAt;

    /**
     * @var \DateTime $bornIn
     *
     * @ORM\Column(name="bornIn", type="string", length=50, nullable=true)
     */
    private $bornIn;

    /**
     * @var \DateTime $diedIn
     *
     * @ORM\Column(name="diedIn", type="string", length=50, nullable=true)
     */
    private $diedIn;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime $anno
     *
     * @ORM\Column(name="anno", type="integer")
     * @Assert\Choice(callback = {"Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer","getAnnosList"})
     */
    private $anno;

    /**
     * @var boolean $pontif
     *
     * @ORM\Column(name="pontif", type="boolean", nullable=true)
     */
    private $pontif;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(fields={"firstname", "lastname"}, updatable=false, unique=true, separator="")
     */
    private $slug;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection $fraHasUsers
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\FraHasUser", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $fraHasUsers;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Email $emails
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Email", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Diploma $diplomas
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Diploma", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $diplomas;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Phone $phones
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Phone", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $phones;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Post $posts
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Post", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $posts;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Address $addresses
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Address", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $addresses;

    /**
     * @var Asbo\WhosWhoBundle\Entity\Job $jobs
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Job", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $jobs;

    /**
     * @var Asbo\WhosWhoBundle\Entity\ExternalPost $externalPosts
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\ExternalPost", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $externalPosts;

    /**
     * @var array $settings
     *
     * @ORM\Column(name="settings", type="array")
     */
    private $settings = array();

    /**
     * @var  array $defaultsettings
     *
     * Default Settings
     */
    private $defaultsettings = array(
        'whoswho'               => true,
        'pereat'                => true,
        'convoc_externe'        => true,
        'convoc_banquet'        => true,
        'convoc_we'             => true,
        'convoc_ephemerides_q1' => true,
        'convoc_ephemerides_q2' => true
    );

    /**
     * Type Fra
     */
    const TYPE_IMPETRANT     = 0;
    const TYPE_IN_SPE        = 1;
    const TYPE_HONORIS_CAUSA = 2;
    const TYPE_CHEVALIER     = 3;

    /**
     * Status Fra
     */
    const STATUS_TYRO             = 0;
    const STATUS_HONORIS_CAUSA    = 1;
    const STATUS_CAPPELANUS       = 2;
    const STATUS_CHEVALIER        = 3;
    const STATUS_CANDIDATUS       = 4;
    const STATUS_CANDIDAT_HONNEUR = 5;
    const STATUS_XHANTIPPE        = 6;
    const STATUS_SODALES          = 7;
    const STATUS_VETERANUS        = 8;
    const STATUS_IN_SPE           = 9;

    public function __construct()
    {

        $this->emails     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->diplomas   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs       = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fraHasUser = new \Doctrine\Common\Collections\ArrayCollection();

        // @todo: Trouver un autre moyen de changer la date !!!
        $annos           = DateToAnnoTransformer::getAnnosList();
        $this->anno      = end($annos);
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
     * Set firstname
     *
     * @param  string $firstname
     * @return Fra
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param  string $lastname
     * @return Fra
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set nickname
     *
     * @param  string $nickname
     * @return string
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return $this
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set bornAt
     *
     * @param \DateTime $bornAt
     * @return $this
     */
    public function setBornAt($bornAt)
    {
        $this->bornAt = $bornAt;

        return $this;
    }

    /**
     * Get bornAt
     *
     * @return \DateTime
     */
    public function getBornAt()
    {
        return $this->bornAt;
    }

    /**
     * Set diedAt
     *
     * @param \DateTime $diedAt
     * @return $this
     */
    public function setDiedAt($diedAt)
    {
        $this->diedAt = $diedAt;

        return $this;
    }

    /**
     * Get diedAt
     *
     * @return \DateTime
     */
    public function getDiedAt()
    {
        return $this->diedAt;
    }

    /**
     * Set bornIn
     *
     * @param string $bornIn
     * @return $this
     */
    public function setBornIn($bornIn)
    {
        $this->bornIn = $bornIn;

        return $this;
    }

    /**
     * Get bornIn
     *
     * @return string
     */
    public function getBornIn()
    {
        return $this->bornIn;
    }

    /**
     * Set diedIn
     *
     * @param  string $diedIn
     * @return Fra
     */
    public function setDiedIn($diedIn)
    {
        $this->diedIn = $diedIn;

        return $this;
    }

    /**
     * Get diedIn
     *
     * @return string
     */
    public function getDiedIn()
    {
        return $this->diedIn;
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
     * Set status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set pontif
     *
     * @param boolean $pontif
     * @return $this
     */
    public function setPontif($pontif)
    {
        $this->pontif = $pontif;

        return $this;
    }

    /**
     * Get pontif
     *
     * @return boolean
     */
    public function isPontif()
    {
        return $this->pontif;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Fra
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set user
     *
     * @param  Asbo\UserBundle\Entity\User $user
     * @return Fra
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Asbo\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

     /**
     * {@inheritdoc}
     */
    public function setFraHasUsers($fraHasUsers)
    {
        $this->fraHasUsers = new ArrayCollection();

        foreach ($fraHasUsers as $fraHasUser) {
            $this->addFraHasUsers($fraHasUser);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFraHasUsers()
    {
        return $this->fraHasUsers;
    }

    /**
     * {@inheritdoc}
     */
    public function addFraHasUsers(FraHasUser $fraHasUser)
    {
        $fraHasUser->setFra($this);

        $this->fraHasUsers[] = $fraHasUser;
    }

    /**
     * Add a email
     *
     * @param \Asbo\WhosWhoBundle\Entity\Email $email
     */
    public function addEmails(Email $email)
    {
        $email->setFra($this);
        $this->emails[] = $email;
    }

    /**
     * Set emails
     *
     * @param array $emails
     */
    public function setEmails($emails)
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($emails as $email) {
            $this->addEmails($email);
        }
    }

    /**
     * Get emails
     *
     * @return array $emails
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add a job
     *
     * @param \Asbo\WhosWhoBundle\Entity\Job $job
     */
    public function addJobs(Job $job)
    {
        $job->setFra($this);
        $this->jobs[] = $job;
    }

    /**
     * Set jobs
     *
     * @param array $jobs
     */
    public function setJobs($jobs)
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($jobs as $job) {
            $this->addJobs($job);
        }
    }

    /**
     * Get jobs
     *
     * @return array $jobs
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add a diploma
     *
     * @param \Asbo\WhosWhoBundle\Entity\Diploma $diploma
     */
    public function addDiplomas(Diploma $diploma)
    {
        $diploma->setFra($this);
        $this->diplomas[] = $diploma;
    }

    /**
     * Set diplomas
     *
     * @param array $diplomas
     */
    public function setDiplomas($diplomas)
    {
        $this->diplomas = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($diplomas as $diploma) {
            $this->addDiplomas($diploma);
        }
    }

    /**
     * Get diplomas
     *
     * @return array $diplomas
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    /**
     * Add a post
     *
     * @param \Asbo\WhosWhoBundle\Entity\Post $post
     */
    public function addPosts(Post $post)
    {
        $post->setFra($this);
        $this->posts[] = $post;
    }

    /**
     * Set posts
     *
     * @param array $posts
     */
    public function setPosts($posts)
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($posts as $post) {
            $this->addPosts($post);
        }
    }

    /**
     * Get posts
     *
     * @return array $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add external posts
     *
     * @param \Asbo\WhosWhoBundle\Entity\ExternalPost $externalPost
     */
    public function addExternalPosts(ExternalPost $externalPost)
    {
        $externalPost->setFra($this);
        $this->externalPosts[] = $externalPost;
    }

    /**
     * Set multiple external posts
     *
     * @param array $externalPosts
     */
    public function setExternalPosts($externalPosts)
    {
        $this->externalPosts = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($externalPosts as $externalPost) {
            $this->addExternalPosts($externalPost);
        }
    }

    /**
     * Get external posts
     *
     * @return array $externalPosts
     */
    public function getExternalPosts()
    {
        return $this->externalPosts;
    }

    /**
     * Add a address
     *
     * @param \Asbo\WhosWhoBundle\Entity\Address $address
     */
    public function addAddresses(Address $address)
    {
        $address->setFra($this);
        $this->addresses[] = $address;
    }

    /**
     * Set addresses
     *
     * @param array $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresss = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($addresses as $address) {
            $this->addAddresses($address);
        }
    }

    /**
     * Get addresses
     *
     * @return array $addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
    /**
     * Add a phone
     *
     * @param \Asbo\WhosWhoBundle\Entity\Phone $phone
     */
    public function addPhones(Phone $phone)
    {
        $phone->setFra($this);
        $this->phones[] = $phone;
    }

    /**
     * Set phones
     *
     * @param array $phones
     */
    public function setPhones($phones)
    {
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection;

        foreach ($phones as $phone) {
            $this->addPhones($phone);
        }
    }

    /**
     * Get phones
     *
     * @return array $phones
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set settings
     *
     * @param  array $settings
     * @return array
     */
    public function setSettings($settings)
    {
        $this->settings = array_merge($this->defaultsettings, array_intersect_key($settings, $this->defaultsettings));

        return $this;
    }

    /**
     * Get settings
     *
     * @return array
     */
    public function getSettings()
    {
        return array_merge($this->defaultsettings, array_intersect_key($this->settings, $this->defaultsettings));
    }

    /**
     * Get Type List
     *
     * @return array
     */
    public static function getTypeList()
    {
        return array(
            self::TYPE_IMPETRANT     => 'Membre Impétrant',
            self::TYPE_IN_SPE        => 'Membre In Spé',
            self::TYPE_HONORIS_CAUSA => 'Membre Honoris Causa',
            self::TYPE_CHEVALIER     => 'Chevalier',
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
     * Get Status List
     *
     * @return array
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_TYRO             => 'Membre Impétrant',
            self::STATUS_HONORIS_CAUSA    => 'Membre Honoris Causa',
            self::STATUS_CAPPELANUS       => 'Cappelanus',
            self::STATUS_CHEVALIER        => 'Chevalier',
            self::STATUS_CANDIDATUS       => 'Candidatus',
            self::STATUS_CANDIDAT_HONNEUR => 'Candidat d\'honneur',
            self::STATUS_XHANTIPPE        => 'Xhantippe',
            self::STATUS_SODALES          => 'Sodales',
            self::STATUS_VETERANUS        => 'Veteranus',
            self::STATUS_IN_SPE           => 'Membre In Spé',
        );

    }

    /**
     * Get Status Code
     *
     * @return string|null
     */
    public function getStatusCode()
    {
        $status = self::getStatusList();

        return isset($status[$this->getStatus()]) ? $status[$this->getStatus()] : null;
    }

    /**
     * Count total denier
     *
     * @return integer
     */
    public function countTotalDenier()
    {
        $annoList = DateToAnnoTransformer::getAnnosList();
        $total    = (end($annoList) - $this->getAnno());

        foreach ($this->getPosts() as $post) {
            $total += $post->getPost()->getDenier();
        }

        return $total;
    }

    /**
     * Auto-render on toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }
}
