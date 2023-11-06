<?php

namespace App\Entity;

use App\Repository\SquadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SquadRepository::class)]
class Squad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Le champ {{ label }} est obligatoire. '
    )]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le {{ label }} doit contenir au moins {{min}} caractères.',
        max: 25,
        maxMessage: 'Le {{ label }} doit contenir au maximum {{ max }} caractères.'
    )]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'squads')]
    private Collection $members;

    #[ORM\ManyToMany(targetEntity: Activity::class, mappedBy: 'Squad')]
    private Collection $activities;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->activities = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->addSquad($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            $activity->removeSquad($this);
        }

        return $this;
    }
}
