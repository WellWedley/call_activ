<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendsRepository::class)]
class Friends
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $friendshipStart = null;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'friends')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getFriendshipStart(): ?DateTimeInterface
    {
        return $this->friendshipStart;
    }

    /**
     * @param DateTimeInterface $friendshipStart
     * @return $this
     */
    public function setFriendshipStart(DateTimeInterface $friendshipStart): static
    {
        $this->friendshipStart = $friendshipStart;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    /**
     * @param user $user
     * @return $this
     */
    public function addUser(user $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    /**
     * @param user $user
     * @return $this
     */
    public function removeUser(user $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }
}
