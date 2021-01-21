<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingCategoryRepository::class)
 */
class ListingCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $texte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $texteaccueil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageaccueil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $accueil;

    /**
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $root;

    /**
     * @ORM\OneToMany(targetEntity=ListingCategoryTranslation::class, mappedBy="ListingCategory")
     */
    private $ListingCategorieTranslation;

    public function __construct()
    {
        $this->ListingCategorieTranslation = new ArrayCollection();
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getTexteaccueil(): ?string
    {
        return $this->texteaccueil;
    }

    public function setTexteaccueil(?string $texteaccueil): self
    {
        $this->texteaccueil = $texteaccueil;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageaccueil(): ?string
    {
        return $this->imageaccueil;
    }

    public function setImageaccueil(?string $imageaccueil): self
    {
        $this->imageaccueil = $imageaccueil;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAccueil(): ?string
    {
        return $this->accueil;
    }

    public function setAccueil(?string $accueil): self
    {
        $this->accueil = $accueil;

        return $this;
    }

    public function getLft(): ?int
    {
        return $this->lft;
    }

    public function setLft(int $lft): self
    {
        $this->lft = $lft;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getRgt(): ?int
    {
        return $this->rgt;
    }

    public function setRgt(int $rgt): self
    {
        $this->rgt = $rgt;

        return $this;
    }

    public function getRoot(): ?int
    {
        return $this->root;
    }

    public function setRoot(?int $root): self
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return Collection|ListingCategoryTranslation[]
     */
    public function getListingCategorieTranslation(): Collection
    {
        return $this->ListingCategorieTranslation;
    }

    public function addListingCategorieTranslation(ListingCategoryTranslation $listingCategorieTranslation): self
    {
        if (!$this->ListingCategorieTranslation->contains($listingCategorieTranslation)) {
            $this->ListingCategorieTranslation[] = $listingCategorieTranslation;
            $listingCategorieTranslation->setListingCategory($this);
        }

        return $this;
    }

    public function removeListingCategorieTranslation(ListingCategoryTranslation $listingCategorieTranslation): self
    {
        if ($this->ListingCategorieTranslation->removeElement($listingCategorieTranslation)) {
            // set the owning side to null (unless already changed)
            if ($listingCategorieTranslation->getListingCategory() === $this) {
                $listingCategorieTranslation->setListingCategory(null);
            }
        }

        return $this;
    }

}
