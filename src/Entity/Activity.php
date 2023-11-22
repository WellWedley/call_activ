<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le champ nom est obligatoire")]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Squad::class, inversedBy: 'activities')]
    private Collection $squad;

    public function __construct()
    {
        $this->squad = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string $place
     *
     * @return $this
     */
    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return $this
     */
    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return static
     */
    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     * @return $this
     */
    public function setDate(DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, Squad>
     */
    public function getSquad(): Collection
    {
        return $this->Squad;
    }

    /**
     * @param Squad $squad
     * @return $this
     */
    public function addSquad(Squad $squad): static
    {
        if (!$this->squad->contains($squad)) {
            $this->squad->add($squad);
        }

        return $this;
    }

    /**
     * @param Squad $squad
     *
     * @return $this
     */
    public function removeSquad(Squad $squad): static
    {
        $this->Squad->removeElement($squad);

        return $this;
    }
}
