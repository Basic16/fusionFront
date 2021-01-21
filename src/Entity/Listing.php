<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * Listing
 *
 * @ORM\Table(name="listing")
 * @ORM\Entity
 */
class Listing
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type", type="smallint", nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="decimal", precision=8, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="certified", type="boolean", nullable=true)
     */
    private $certified;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_duration", type="smallint", nullable=true)
     */
    private $minDuration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_duration", type="smallint", nullable=true)
     */
    private $maxDuration;

    /**
     * @var int
     *
     * @ORM\Column(name="cancellation_policy", type="smallint", nullable=false)
     */
    private $cancellationPolicy;

    /**
     * @var int|null
     *
     * @ORM\Column(name="average_rating", type="smallint", nullable=true)
     */
    private $averageRating;

    /**
     * @var int|null
     *
     * @ORM\Column(name="comment_count", type="integer", nullable=true)
     */
    private $commentCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="admin_notation", type="decimal", precision=3, scale=1, nullable=true)
     */
    private $adminNotation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="availabilities_updated_at", type="datetime", nullable=true)
     */
    private $availabilitiesUpdatedAt;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mariage", mappedBy="listing")
     */
    private $mariage;

    /**
     * @ORM\OneToMany(targetEntity=ListingImage::class, mappedBy="Listing")
     */
    private $ListingImage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listing")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mariage = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ListingImage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCertified(): ?bool
    {
        return $this->certified;
    }

    public function setCertified(?bool $certified): self
    {
        $this->certified = $certified;

        return $this;
    }

    public function getMinDuration(): ?int
    {
        return $this->minDuration;
    }

    public function setMinDuration(?int $minDuration): self
    {
        $this->minDuration = $minDuration;

        return $this;
    }

    public function getMaxDuration(): ?int
    {
        return $this->maxDuration;
    }

    public function setMaxDuration(?int $maxDuration): self
    {
        $this->maxDuration = $maxDuration;

        return $this;
    }

    public function getCancellationPolicy(): ?int
    {
        return $this->cancellationPolicy;
    }

    public function setCancellationPolicy(int $cancellationPolicy): self
    {
        $this->cancellationPolicy = $cancellationPolicy;

        return $this;
    }

    public function getAverageRating(): ?int
    {
        return $this->averageRating;
    }

    public function setAverageRating(?int $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getCommentCount(): ?int
    {
        return $this->commentCount;
    }

    public function setCommentCount(?int $commentCount): self
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    public function getAdminNotation(): ?string
    {
        return $this->adminNotation;
    }

    public function setAdminNotation(?string $adminNotation): self
    {
        $this->adminNotation = $adminNotation;

        return $this;
    }

    public function getAvailabilitiesUpdatedAt(): ?\DateTimeInterface
    {
        return $this->availabilitiesUpdatedAt;
    }

    public function setAvailabilitiesUpdatedAt(?\DateTimeInterface $availabilitiesUpdatedAt): self
    {
        $this->availabilitiesUpdatedAt = $availabilitiesUpdatedAt;

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

    /**
     * @return Collection|ListingImage[]
     */
    public function getListingImage(): Collection
    {
        return $this->ListingImage;
    }

    public function addListingImage(ListingImage $listingImage): self
    {
        if (!$this->ListingImage->contains($listingImage)) {
            $this->ListingImage[] = $listingImage;
            $listingImage->setListing($this);
        }

        return $this;
    }

    public function removeListingImage(ListingImage $listingImage): self
    {
        if ($this->ListingImage->removeElement($listingImage)) {
            // set the owning side to null (unless already changed)
            if ($listingImage->getListing() === $this) {
                $listingImage->setListing(null);
            }
        }

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
