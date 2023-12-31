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
    #[Assert\NotBlank(message: 'Le champ {{ label }} est obligatoire. ')]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: 'Le {{ label }} doit contenir au moins {{min}} caractères.',
        maxMessage: 'Le {{ label }} doit contenir au maximum {{ max }} caractères.'
    )]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'squads')]
    private Collection $members;

    #[ORM\ManyToMany(targetEntity: Activity::class, mappedBy: 'Squad')]
    private Collection $activities;

    #[ORM\ManyToOne(inversedBy: 'included_in_squads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $owner = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * @param User $member
     * @return $this
     */
    public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    /**
     * @param User $member
     * @return $this
     */
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

    /**
     * @param Activity $activity
     * @return $this
     */
    public function addActivity(Activity $activity): static
    {
        if (!$this->activities->contains($activity)) {
            $this->activities->add($activity);
            $activity->addSquad($this);
        }

        return $this;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function removeActivity(Activity $activity): static
    {
        if ($this->activities->removeElement($activity)) {
            $activity->removeSquad($this);
        }

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
