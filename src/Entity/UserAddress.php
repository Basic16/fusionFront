<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserAddress
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint", nullable=false, options={"default"="1"})
     */
    private $type = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true) 
     */
    private $city;

    /**
     * @var string|null
     *
     * @Groups("user")
     * @ORM\Column(name="zip", type="string", length=50, nullable=true)
     * 
     */
    private $zip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=3, nullable=true)
     */
    private $country;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="address")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     */
    private $addresses;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="address")
     */
    private $user;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getImages(): ?User
    {
        return $this->images;
    }

    public function setImages(?User $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getAddresses(): ?User
    {
        return $this->addresses;
    }

    public function setAddresses(?User $addresses): self
    {
        $this->addresses = $addresses;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
