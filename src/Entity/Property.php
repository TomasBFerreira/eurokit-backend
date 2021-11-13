<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 */
class Property
    {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    public function __construct()
        {
        $this->id = Uuid::uuid4()->toString();
        }

    public function getId(): string
        {
        return $this->id;
        }

    public function getName(): ?string
        {
        return $this->name;
        }

    public function setName(string $name): self
        {
        $this->name = $name;

        return $this;
        }

    public function getValue(): ?string
        {
        return $this->value;
        }

    public function setValue(string $value): self
        {
        $this->value = $value;

        return $this;
        }

    public function getModel(): ?Model
        {
        return $this->model;
        }

    public function setModel(?Model $model): self
        {
        $this->model = $model;

        return $this;
        }

    }
