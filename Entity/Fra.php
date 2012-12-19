<?php

namespace Asbo\WhosWhoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GEDMO;
use Symfony\Component\Validator\Constraints as Assert;
use Asbo\WhosWhoBundle\Form\DataTransformer\DateToAnnoTransformer;

/**
 * Asbo\WhosWhoBundle\Entity\Fra
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
     * @var \stdClass $user
     *
     * @ORM\ManyToOne(targetEntity="Asbo\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var emails
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Email", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @var diplomas
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Diploma", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $diplomas;

    /**
     * @var phones
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Phone", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $phones;

    /**
     * @var posts
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Post", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $posts;

    /**
     * @var addresses
     *
     * @ORM\OneToMany(targetEntity="Asbo\WhosWhoBundle\Entity\Address", mappedBy="fra", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $addresses;

    /**
     * @var array $settings
     *
     * @ORM\Column(name="settings", type="array")
     */
    private $settings = array();

    /**
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emails    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->diplomas  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts     = new \Doctrine\Common\Collections\ArrayCollection();

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
     * __toString
     */
    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
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
     * @return Fra
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
     * @param  boolean $gender
     * @return Fra
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
     * @param  \DateTime $bornAt
     * @return Fra
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
     * @param  \DateTime $diedAt
     * @return Fra
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
     * @param  string $bornIn
     * @return Fra
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
     * @param  integer $type
     * @return Fra
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
     * @param  integer $status
     * @return Fra
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
     * @param  integer $anno
     * @return Fra
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
     * Get Anno To Date
     *
     * @return \DateTime('%y')
     */
    public function getAnnoToDates()
    {
        $transformer = new DateToAnnoTransformer();

        return ($transformer->reverseTransform($this->anno)->format('Y') - 1).' - '.$transformer->reverseTransform($this->anno)->format('Y');
    }

    /**
     * Set pontif
     *
     * @param  boolean $pontif
     * @return Fra
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
    public function getPontif()
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
    public function setUser(\Asbo\UserBundle\Entity\User $user = null)
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
     * Count Denier
     */
    public function countTotalDenier()
    {
        $annoList = DateToAnnoTransformer::getAnnosList();
        $total    = (end($annoList) - $this->getAnno());

        foreach($this->getPosts() as $post)
          $total += $post->getPost()->getDenier();

        return $total;
    }

    /**
     * Add emails
     *
     * @param  Asbo\WhosWhoBundle\Entity\Email $emails
     * @return Fra
     */
    public function addEmail(\Asbo\WhosWhoBundle\Entity\Email $emails)
    {
        $emails->setFra($this);
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $emails
     */
    public function removeEmail(\Asbo\WhosWhoBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    public function setEmails(\Doctrine\Common\Collections\ArrayCollection $emails)
    {
        foreach ($emails as $email) {
            $email->setFra($this);
        }
        $this->emails = $emails;
    }

    public function addEmails($emails)
    {
        switch (true) {
            case is_array($emails):
                $emails       = new ArrayCollection($emails);
                $this->setEmails($emails);
                break;
            case $emails instanceof ArrayCollection:
                $this->setEmails($emails);
                break;
            case $emails instanceof Email:
                $this->addEmail($emails);
                break;
            default:
                throw new \Exception('Unknown parameter type: ' . var_dump($emails, true));
        }
    }

    /**
     * Add diplomas
     *
     * @param  Asbo\WhosWhoBundle\Entity\Diploma $diplomas
     * @return Fra
     */
    public function addDiploma(\Asbo\WhosWhoBundle\Entity\Diploma $diplomas)
    {
        $diplomas->setFra($this);
        $this->diplomas[] = $diplomas;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $emails
     */
    public function removeDiploma(\Asbo\WhosWhoBundle\Entity\Diploma $diplomas)
    {
        $this->diplomas->removeElement($diplomas);
    }

    /**
     * Get diplomas
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDiplomas()
    {
        return $this->diplomas;
    }

    public function setDiplomas(\Doctrine\Common\Collections\ArrayCollection $diplomas)
    {
        foreach ($diplomas as $diploma) {
            $diploma->setFra($this);
        }
        $this->diplomas = $diplomas;
    }

    public function addDiplomas($diplomas)
    {
        switch (true) {
            case is_array($diplomas):
                $diplomas = new ArrayCollection($diplomas);
                $this->setDiplomas($diplomas);
                break;
            case $diplomas instanceof ArrayCollection:
                $this->setDiplomas($diplomas);
                break;
            case $diplomas instanceof diploma:
                $this->addDiploma($diplomas);
                break;
            default:
                throw new \Exception('Unknown parameter type: ' . var_dump($diplomas, true));
        }
    }

    /**
     * Add post
     *
     * @param  Asbo\WhosWhoBundle\Entity\Post $post
     * @return Fra
     */
    public function addPost(\Asbo\WhosWhoBundle\Entity\Post $post)
    {
        $post->setFra($this);
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param Asbo\WhosWhoBundle\Entity\Email $post
     */
    public function removePost(\Asbo\WhosWhoBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function setPosts(\Doctrine\Common\Collections\ArrayCollection $posts)
    {
        foreach ($posts as $post) {
            $post->setFra($this);
        }
        $this->posts = $posts;
    }

    public function addPosts($posts)
    {
        switch (true) {
            case is_array($posts):
                $posts = new ArrayCollection($posts);
                $this->setPosts($posts);
                break;
            case $posts instanceof ArrayCollection:
                $this->setPosts($posts);
                break;
            case $posts instanceof Post:
                $this->addPost($posts);
                break;
            default:
                throw new \Exception('Unknown parameter type: ' . var_dump($posts, true));
        }
    }

    /**
     * Add address
     *
     * @param  Asbo\WhosWhoBundle\Entity\Address $address
     * @return Fra
     */
    public function addAddress(\Asbo\WhosWhoBundle\Entity\Address $address)
    {
        $address->setFra($this);
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param Asbo\WhosWhoBundle\Entity\Address $address
     */
    public function removeAddress(\Asbo\WhosWhoBundle\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresss
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAddresses(\Doctrine\Common\Collections\ArrayCollection $addresses)
    {
        foreach ($addresses as $address) {
            $address->setFra($this);
        }
        $this->addresses = $addresses;
    }

    public function addAddresses($addresses)
    {
        switch (true) {
            case is_array($addresses):
                $addresses = new ArrayCollection($addresses);
                $this->setAddresses($addresses);
                break;
            case $addresses instanceof ArrayCollection:
                $this->setAddresses($addresses);
                break;
            case $addresses instanceof Address:
                $this->addAddress($addresses);
                break;
            default:
                throw new \Exception('Unknown parameter type: ' . var_dump($addresses, true));
        }
    }

    /**
     * Add phone
     *
     * @param  Asbo\WhosWhoBundle\Entity\Phone $phone
     * @return Fra
     */
    public function addPhone(\Asbo\WhosWhoBundle\Entity\Phone $phone)
    {
        $phone->setFra($this);
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param Asbo\WhosWhoBundle\Entity\Phone $phone
     */
    public function removePhone(\Asbo\WhosWhoBundle\Entity\Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phones
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Set multiple phone number
     *
     * @return Fra
     * @param  ArrayCollection $phones
     **/
    public function setPhones(\Doctrine\Common\Collections\ArrayCollection $phones)
    {
        foreach ($phones as $phone) {
            $phone->setFra($this);
        }
        $this->phones = $phones;

        return $this;
    }

    public function addPhones($phones)
    {
        switch (true) {
            case is_array($phones):
                $phones = new ArrayCollection($phones);
                $this->setPhones($phones);
                break;
            case $phones instanceof ArrayCollection:
                $this->setPhones($phones);
                break;
            case $phones instanceof Phone:
                $this->addPhone($phones);
                break;
            default:
                throw new \Exception('Unknown parameter type: ' . var_dump($phones, true));
        }
    }

    /**
     * Set settings
     *
     * @param  array    $settings
     * @return Settings
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
     */
    public function getTypeCode()
    {
        $type = self::getTypeList();

        return isset($type[$this->getType()]) ? $type[$this->getType()] : null;
    }

    /**
     * Get Status List
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
     */
    public function getStatusCode()
    {
        $status = self::getStatusList();

        return isset($status[$this->getStatus()]) ? $status[$this->getStatus()] : null;
    }
}
