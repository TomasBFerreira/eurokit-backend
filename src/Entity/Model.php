<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=Property::class, mappedBy="model", orphanRemoval=true)
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=Size::class, mappedBy="model", orphanRemoval=true)
     */
    private $sizes = [];

    /**
     *@ORM\Column(type="simple_array")
     */
    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setModel($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getModel() === $this) {
                $property->setModel(null);
            }
        }

        return $this;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }

    public function setSizes(array $sizes): self
    {
        $this->sizes = $sizes;

        return $this;
    }
}
