<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User 
{

    const PERSON_TYPE_NATURAL = 1;
    const PERSON_TYPE_LEGAL = 2;

    public static $personTypeValues = array(
        self::PERSON_TYPE_NATURAL => 'une personne',
        self::PERSON_TYPE_LEGAL => 'une entreprise',
    );

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="cocorico_user.username.short",
     *     maxMessage="cocorico_user.username.long"   
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $countryofresidence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=6)
     */
    protected $phonePrefix = '+33';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @ORM\column(type="smallint", length=2)
     */    
    private $personType = self::PERSON_TYPE_NATURAL;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=UserAddress::class, mappedBy="user")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=UserImage::class, mappedBy="user")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Listing::class, mappedBy="user")
     */
    private $listing;

    public function __construct()
    {
        $this->fichiers = new ArrayCollection();
        $this->address = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->listing = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPersonType()
    {
        if (!$this->personType) {
            $this->personType = self::PERSON_TYPE_NATURAL;
        }

        return $this->personType;
    }

    public function setPersonType($personType)
    {
        if (!in_array($personType, array_keys(self::$personTypeValues))) {
            throw new \InvalidArgumentException(
                sprintf('Invalid value for user.person_type : %s.', $personType)
            );
        }

        $this->personType = $personType;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }


    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getCountryofresidence(): ?string
    {
        return $this->countryofresidence;
    }

    public function setCountryofresidence(string $countryofresidence): self
    {
        $this->countryofresidence = $countryofresidence;

        return $this;
    }

    
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhonePrefix()
    {
        return $this->phonePrefix;
    }

    public function setPhonePrefix($phonePrefix)
    {
        $this->phonePrefix = $phonePrefix;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|UserAddress[]
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(UserAddress $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(UserAddress $address): self
    {
        if ($this->address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(UserImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(UserImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Listing[]
     */
    public function getListing(): Collection
    {
        return $this->listing;
    }

    public function addListing(Listing $listing): self
    {
        if (!$this->listing->contains($listing)) {
            $this->listing[] = $listing;
            $listing->setUser($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listing->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getUser() === $this) {
                $listing->setUser(null);
            }
        }

        return $this;
    }
}