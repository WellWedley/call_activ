<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pict = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Activity::class)]
    private Collection $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPict(): ?string
    {
        return $this->pict;
    }

    /**
     * @param string|null $pict
     * @return $this
     */
    public function setPict(?string $pict): static
    {
        $this->pict = $pict;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function removeActivity(Activity $activity): static
    {
        // set the owning side to null (unless already changed)
        if ($this->activities->removeElement($activity) && $activity->getCategory() === $this) {
            $activity->setCategory(null);
        }

        return $this;
    }
}
