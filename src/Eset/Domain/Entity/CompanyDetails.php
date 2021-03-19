<?php

namespace App\Eset\Domain\Entity;

use App\EsdPortal\Domain\Entity\Company;
use App\Eset\Infrastructure\Repository\CompanyDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyDetailsRepository::class)
 */
class CompanyDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\column(type="integer", nullable=false)
     */
    private $companyId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mollieKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mollieTestKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $esetGuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $esetKey;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="company")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=CompanyProductDetailsLink::class, mappedBy="company")
     */
    private $productDetailsLinks;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->productDetailsLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company)
    {
        $this->company = $company;

        return $this;
    }

    public function getMollieKey(): ?string
    {
        return $this->mollieKey;
    }

    public function setMollieKey(?string $mollieKey): self
    {
        $this->mollieKey = $mollieKey;

        return $this;
    }

    public function getEsetGuid(): ?string
    {
        return $this->esetGuid;
    }

    public function setEsetGuid(?string $esetGuid): self
    {
        $this->esetGuid = $esetGuid;

        return $this;
    }

    public function getEsetKey(): ?string
    {
        return $this->esetKey;
    }

    public function setEsetKey(?string $esetKey): self
    {
        $this->esetKey = $esetKey;

        return $this;
    }


    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCompanyDetails($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCompanyDetails() === $this) {
                $order->setCompanyDetails(null);
            }
        }

        return $this;
    }

    public function getMollieTestKey(): ?string
    {
        return $this->mollieTestKey;
    }

    public function setMollieTestKey(?string $mollieTestKey): self
    {
        $this->mollieTestKey = $mollieTestKey;

        return $this;
    }


    /**
     * @return Collection|CompanyProductDetailsLink[]
     */
    public function getProductDetailsLinks(): Collection
    {
        return $this->productDetailsLinks;
    }

    public function addProductDetailsLink(CompanyProductDetailsLink $productDetailsLink): self
    {
        if (!$this->productDetailsLinks->contains($productDetailsLink)) {
            $this->productDetailsLinks[] = $productDetailsLink;
            $productDetailsLink->setCompanyDetails($this);
        }

        return $this;
    }

    public function removeProductDetailLink(CompanyProductDetailsLink $productDetailsLink): self
    {
        if ($this->productDetailsLinks->removeElement($productDetailsLink)) {
            // set the owning side to null (unless already changed)
            if ($productDetailsLink->getCompanyDetails() === $this) {
                $productDetailsLink->setCompanyDetails(null);
            }
        }

        return $this;
    }

}
