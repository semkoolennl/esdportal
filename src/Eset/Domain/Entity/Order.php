<?php

namespace App\Eset\Domain\Entity;

use App\Eset\Infrastructure\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mollieId;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyDetails::class, inversedBy="orders")
     */
    private $companyDetails;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $data = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMollieId(): ?string
    {
        return $this->mollieId;
    }

    public function setMollieId(?string $mollieId): self
    {
        $this->mollieId = $mollieId;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
