<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column]
    private ?int $Price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Squad::class, inversedBy: 'activities')]
    private Collection $Squad;

    public function __construct()
    {
        $this->Squad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * @return Collection<int, Squad>
     */
    public function getSquad(): Collection
    {
        return $this->Squad;
    }

    public function addSquad(Squad $squad): static
    {
        if (!$this->Squad->contains($squad)) {
            $this->Squad->add($squad);
        }

        return $this;
    }

    public function removeSquad(Squad $squad): static
    {
        $this->Squad->removeElement($squad);

        return $this;
    }
}
