<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass=SizeRepository::class)
 */
class Size
    {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="sizes")
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

    public function getSize(): ?string
        {
        return $this->size;
        }

    public function setSize(string $size): self
        {
        $this->size = $size;

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
