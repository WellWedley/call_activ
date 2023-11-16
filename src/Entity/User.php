<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Ce compte existe déjà.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(
        message: 'L\'adresse \'{{value}} n\'est pas valide.\'',
        mode: 'html5'
    )]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(
        min: 8,
        max: 4096,
        minMessage: 'Votre mot de passe doit contenir au moins {{ min }} caractères.',
        maxMessage: 'Votre mot de passe doit contenir au maximum {{ max }} caractères.',
    )]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[Assert\NotBlank(
        message: 'Le champ {{ label }} est obligatoire. '
    )]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le {{ label }} doit contenir au moins {{ min }} caractères.',
        max: 20,
        maxMessage: 'Le {{ label }} doit contenir au maximum {{ max }} caractères.'
    )]
    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Le champ {{ label }} est obligatoire.'
    )]
    #[Assert\Length(
        min: 3,
        minMessage: 'Le {{ label }} doit contenir au moins {{ min }} caractères.',
        max: 20,
        maxMessage: 'Le {{ label }} doit contenir au maximum {{ max }} caractères.'
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Positive(
        message: 'Le numéro {{ label }} de téléphone est invalide.'
    )]
    #[Assert\NotBlank(
        message: 'Le champ {{ label }} est obligatoire. '
    )]
    #[Assert\Length(
        exactly: 10,
        exactMessage: 'Le numéro doit contenir {{ limit }} chiffres. ( Actuel : {{ value_length }} chiffres ). ',
    )]
    private ?string $PhoneNumber = null;

    #[ORM\ManyToMany(targetEntity: Squad::class, mappedBy: 'members')]
    private Collection $squads;

    #[ORM\ManyToMany(targetEntity: Friends::class, mappedBy: 'User')]
    private Collection $friends;

    public function __construct()
    {
        $this->squads = new ArrayCollection();
        $this->friends = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Squad>
     */
    public function getSquads(): Collection
    {
        return $this->squads;
    }

    public function addSquad(Squad $squad): static
    {
        if (!$this->squads->contains($squad)) {
            $this->squads->add($squad);
            $squad->addMember($this);
        }

        return $this;
    }

    public function removeSquad(Squad $squad): static
    {
        if ($this->squads->removeElement($squad)) {
            $squad->removeMember($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Friends>
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(Friends $friend): static
    {
        if (!$this->friends->contains($friend)) {
            $this->friends->add($friend);
            $friend->addUser($this);
        }

        return $this;
    }

    public function removeFriend(Friends $friend): static
    {
        if ($this->friends->removeElement($friend)) {
            $friend->removeUser($this);
        }

        return $this;
    }
}
