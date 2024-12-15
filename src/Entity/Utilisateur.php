<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]

    private ?int $Tel = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column]
    private bool $isVerified = true;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $verificationToken = null;

    /**
     * @var Collection<int, AnnoncesColocation>
     */
    #[ORM\OneToMany(targetEntity: AnnoncesColocation::class, mappedBy: 'UserId')]
    private Collection $annoncesColocations;

    // #[ORM\OneToOne(mappedBy: 'ProprietaireId', cascade: ['persist', 'remove'])]
    // private ?Logement $logement = null;

    /**
     * @var Collection<int, Logement>
     */
    #[ORM\OneToMany(targetEntity: Logement::class, mappedBy: 'ProprietaireId')]
    private Collection $logements;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'user')]
    private Collection $comments;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'sender')]
    private Collection $messages;

    /**
     * @var Collection<int, Discussions>
     */
    #[ORM\OneToMany(targetEntity: Discussions::class, mappedBy: 'participant1')]
    private Collection $discussionsAsParticipant1;

    /**
     * @var Collection<int, Discussions>
     */
    #[ORM\OneToMany(targetEntity: Discussions::class, mappedBy: 'participant2')]
    private Collection $discussionsAsParticipant2;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isVerified = false; // Set isVerified to true by default
        $this->annoncesColocations = new ArrayCollection();
        $this->logements = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->discussionsAsParticipant1 = new ArrayCollection();
        $this->discussionsAsParticipant2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addCreatedlog(Logement $logement): static
    {
        if (!$this->logements->contains($logement)) {
            $this->logements->add($logement);
            $logement->setProprietaireId($this);

        }

        return $this;
    }
    public function addCreatedann(AnnoncesColocation $ann): static
    {
        if (!$this->annoncesColocations->contains($ann)) {
            $this->annoncesColocations->add($ann);
            $ann->setUserId($this);

        }

        return $this;
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
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->Tel;
    }

    public function setTel(int $Tel): static
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): static
    {
        $this->verificationToken = $verificationToken;

        return $this;
    }

    public function getName(): string
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, AnnoncesColocation>
     */
    public function getAnnoncesColocations(): Collection
    {
        return $this->annoncesColocations;
    }

    public function addAnnoncesColocation(AnnoncesColocation $annoncesColocation): static
    {
        if (!$this->annoncesColocations->contains($annoncesColocation)) {
            $this->annoncesColocations->add($annoncesColocation);
            $annoncesColocation->setUserId($this);
        }

        return $this;
    }

    public function removeAnnoncesColocation(AnnoncesColocation $annoncesColocation): static
    {
        if ($this->annoncesColocations->removeElement($annoncesColocation)) {
            // set the owning side to null (unless already changed)
            if ($annoncesColocation->getUserId() === $this) {
                $annoncesColocation->setUserId(null);
            }
        }

        return $this;
    }

    // public function getLogement(): ?Logement
    // {
    //     return $this->logement;
    // }

    // public function setLogement(Logement $logement): static
    // {
    //     // set the owning side of the relation if necessary
    //     if ($logement->getProprietaireId() !== $this) {
    //         $logement->setProprietaireId($this);
    //     }

    //     $this->logement = $logement;

    //     return $this;
    // }
    public function __toString(): string
    {
        return $this->nom; 
    }

    /**
     * @return Collection<int, Logement>
     */
    public function getLogements(): Collection
    {
        return $this->logements;
    }

    public function addLogement(Logement $logement): static
    {
        if (!$this->logements->contains($logement)) {
            $this->logements->add($logement);
            $logement->setProprietaireId($this);
        }

        return $this;
    }

    public function removeLogement(Logement $logement): static
    {
        if ($this->logements->removeElement($logement)) {
            // set the owning side to null (unless already changed)
            if ($logement->getProprietaireId() === $this) {
                $logement->setProprietaireId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

   

    /**
     * @return Collection<int, Discussions>
     */
    public function getDiscussionsAsParticipant1(): Collection
    {
        return $this->discussionsAsParticipant1;
    }

    public function addDiscussionAsParticipant1(Discussions $discussion): static
    {
        if (!$this->discussionsAsParticipant1->contains($discussion)) {
            $this->discussionsAsParticipant1->add($discussion);
            $discussion->setParticipant1($this);
        }

        return $this;
    }

    

    /**
     * @return Collection<int, Discussions>
     */
    public function getDiscussionsAsParticipant2(): Collection
    {
        return $this->discussionsAsParticipant2;
    }

    public function addDiscussionAsParticipant2(Discussions $discussion): static
    {
        if (!$this->discussionsAsParticipant2->contains($discussion)) {
            $this->discussionsAsParticipant2->add($discussion);
            $discussion->setParticipant2($this);
        }

        return $this;
    }

    
}

