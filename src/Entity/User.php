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
        max: 20,
        minMessage: 'Le {{ label }} doit contenir au moins {{ min }} caractères.',
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
        max: 20,
        minMessage: 'Le {{ label }} doit contenir au moins {{ min }} caractères.',
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

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Squad::class)]
    private Collection $included_in_squads;

    public function __construct()
    {
        $this->squads = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->included_in_squads = new ArrayCollection();
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
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

    /**
     * @param array $roles
     *
     * @return $this
     */
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

    /**
     * @param string $password
     *
     * @return $this
     */
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

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $isVerified
     *
     * @return $this
     */
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->Nom;
    }

    /**
     * @param string $Nom
     *
     * @return $this
     */
    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     *
     * @return $this
     */
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    /**
     * @param string $PhoneNumber
     *
     * @return $this
     */
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

    /**
     * @param Squad $squad
     *
     * @return $this
     */
    public function addSquad(Squad $squad): static
    {
        if (!$this->squads->contains($squad)) {
            $this->squads->add($squad);
            $squad->addMember($this);
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

    /**
     * @param Friends $friend
     *
     * @return $this
     */
    public function addFriend(Friends $friend): static
    {
        if (!$this->friends->contains($friend)) {
            $this->friends->add($friend);
            $friend->addUser($this);
        }

        return $this;
    }

    /**
     * @param Friends $friend
     *
     * @return $this
     */
    public function removeFriend(Friends $friend): static
    {
        if ($this->friends->removeElement($friend)) {
            $friend->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Squad>
     */
    public function getIncludedInSquads(): Collection
    {
        return $this->included_in_squads;
    }

    public function addIncludedInSquad(Squad $includedInSquad): static
    {
        if (!$this->included_in_squads->contains($includedInSquad)) {
            $this->included_in_squads->add($includedInSquad);
            $includedInSquad->setOwner($this);
        }

        return $this;
    }

    public function removeIncludedInSquad(Squad $includedInSquad): static
    {
        if ($this->included_in_squads->removeElement($includedInSquad)) {
            // set the owning side to null (unless already changed)
            if ($includedInSquad->getOwner() === $this) {
                $includedInSquad->setOwner(null);
            }
        }

        return $this;
    }
}
