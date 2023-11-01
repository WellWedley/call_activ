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

    /**
     * @return int  
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     *@param string     $name
     *
     * @return string   
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string $place
     * 
     * @return string
     */
    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->Category;
    }

    /**
     * @param string $Category
     * 
     * @return Category
     */
    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->Price;
    }

    /**
     * @param int $Price
     * 
     * @return static
     */
    public function setPrice(int $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    /**
     * @param \DateTimeInterface $Date
     */
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

    /**
     * @param Squad $squad
     */
    public function addSquad(Squad $squad): static
    {
        if (!$this->Squad->contains($squad)) {
            $this->Squad->add($squad);
        }

        return $this;
    }

    /**
     * @param Squad $squad
     */
    public function removeSquad(Squad $squad): static
    {
        $this->Squad->removeElement($squad);

        return $this;
    }
}
