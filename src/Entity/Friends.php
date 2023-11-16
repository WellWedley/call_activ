<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
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
    private ?\DateTimeInterface $friendship_start = null;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'friends')]
    private Collection $User;

    public function __construct()
    {
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFriendshipStart(): ?\DateTimeInterface
    {
        return $this->friendship_start;
    }

    public function setFriendshipStart(\DateTimeInterface $friendship_start): static
    {
        $this->friendship_start = $friendship_start;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(user $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
        }

        return $this;
    }

    public function removeUser(user $user): static
    {
        $this->User->removeElement($user);

        return $this;
    }
}
