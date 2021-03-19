<?php

namespace App\Eset\Domain\Entity;

use App\Eset\Infrastructure\Repository\CompanyProductDetailsLinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyProductDetailsLinkRepository::class)
 */
class CompanyProductDetailsLink
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyDetails::class, inversedBy="productDetailLinks")
     */
    private $companyDetails;

    /**
     * @ORM\ManyToOne(targetEntity=ProductDetails::class, inversedBy="links")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productDetails;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyDetails(): ?CompanyDetails
    {
        return $this->companyDetails;
    }

    public function setCompanyDetails(?CompanyDetails $companyDetails): self
    {
        $this->companyDetails = $companyDetails;

        return $this;
    }

    public function getProductDetails(): ?ProductDetails
    {
        return $this->productDetails;
    }

    public function setProductDetails(?ProductDetails $productDetails): self
    {
        $this->productDetails = $productDetails;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
}
