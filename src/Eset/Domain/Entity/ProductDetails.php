<?php

namespace App\Eset\Domain\Entity;

use App\Eset\Infrastructure\Repository\ProductDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductDetailsRepository::class)
 */
class ProductDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $standard;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerImage;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tags = [];

    /**
     * @ORM\OneToMany(targetEntity=CompanyProductDetailsLink::class, mappedBy="productDetail", orphanRemoval=false)
     */
    private $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStandard(): ?bool
    {
        return $this->standard;
    }

    public function setStandard(bool $standard): self
    {
        $this->standard = $standard;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getHeaderImage(): ?string
    {
        return $this->headerImage;
    }

    public function setHeaderImage(string $headerImage): self
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Collection|CompanyProductDetailsLink[]
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(CompanyProductDetailsLink $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setProductDetails($this);
        }

        return $this;
    }

    public function removeLink(CompanyProductDetailsLink $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getProductDetails() === $this) {
                $link->setProductDetails(null);
            }
        }

        return $this;
    }
}
