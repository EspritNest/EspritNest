<?php

namespace App\Entity;

use App\Repository\AnnoncesColocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnnoncesColocationRepository::class)]
class AnnoncesColocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;



    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"titre is required")]
    #[Assert\Regex(
        pattern: '/^\D+$/',
        message: "Ce champ ne doit pas contenir de chiffres."
    )]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank (message:"Description is required")]

    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"Nb chambres is required")]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: "Ce champ doit contenir uniquement des chiffres."
    )]
    private ?int $nombre_chambres = null;

    #[ORM\Column]
    #[Assert\NotBlank (message:"prix is required")]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: "Ce champ doit contenir uniquement des chiffres."
    )]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank (message:"date is required")]
    private ?\DateTimeInterface $date_pub = null;

    #[ORM\ManyToOne(inversedBy: 'Annonces')]
    #[Assert\NotBlank (message:"logement is required")]
    private ?Logement $Logement = null;

    #[ORM\ManyToOne(inversedBy: 'annoncesColocations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank (message:"User Id is required")]
    private ?Utilisateur $UserId = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'Annonce')]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNombreChambres(): ?int
    {
        return $this->nombre_chambres;
    }

    public function setNombreChambres(int $nombre_chambres): static
    {
        $this->nombre_chambres = $nombre_chambres;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->date_pub;
    }

    public function setDatePub(\DateTimeInterface $date_pub): static
    {
        $this->date_pub = $date_pub;

        return $this;
    }

    public function getLogement(): ?Logement
    {
        return $this->Logement;
    }

    public function setLogement(?Logement $Logement): static
    {
        $this->Logement = $Logement;

        return $this;
    }

    public function getUserId(): ?Utilisateur
    {
        return $this->UserId;
    }

    public function setUserId(?Utilisateur $UserId): static
    {
        $this->UserId = $UserId;

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
            $comment->setAnnonce($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAnnonce() === $this) {
                $comment->setAnnonce(null);
            }
        }

        return $this;
    }
}
