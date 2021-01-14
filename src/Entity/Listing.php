<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 */
class Listing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $location_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $certified;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $max_duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $cancellation_policy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $average_rating;

    /**
     * @ORM\Column(type="integer")
     */
    private $comment_count;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admin_notation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $availabilities_updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLocationId(): ?int
    {
        return $this->location_id;
    }

    public function setLocationId(int $location_id): self
    {
        $this->location_id = $location_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCertified(): ?int
    {
        return $this->certified;
    }

    public function setCertified(int $certified): self
    {
        $this->certified = $certified;

        return $this;
    }

    public function getMaxDuration(): ?string
    {
        return $this->max_duration;
    }

    public function setMaxDuration(?string $max_duration): self
    {
        $this->max_duration = $max_duration;

        return $this;
    }

    public function getCancellationPolicy(): ?int
    {
        return $this->cancellation_policy;
    }

    public function setCancellationPolicy(int $cancellation_policy): self
    {
        $this->cancellation_policy = $cancellation_policy;

        return $this;
    }

    public function getAverageRating(): ?string
    {
        return $this->average_rating;
    }

    public function setAverageRating(?string $average_rating): self
    {
        $this->average_rating = $average_rating;

        return $this;
    }

    public function getCommentCount(): ?int
    {
        return $this->comment_count;
    }

    public function setCommentCount(int $comment_count): self
    {
        $this->comment_count = $comment_count;

        return $this;
    }

    public function getAdminNotation(): ?string
    {
        return $this->admin_notation;
    }

    public function setAdminNotation(?string $admin_notation): self
    {
        $this->admin_notation = $admin_notation;

        return $this;
    }

    public function getAvailabilitiesUpdatedAt(): ?\DateTimeInterface
    {
        return $this->availabilities_updated_at;
    }

    public function setAvailabilitiesUpdatedAt(?\DateTimeInterface $availabilities_updated_at): self
    {
        $this->availabilities_updated_at = $availabilities_updated_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
