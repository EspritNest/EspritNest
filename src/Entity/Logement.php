<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogementRepository::class)]
class Logement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Adresse = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $Code_postal = null;

    #[ORM\Column]
    private ?float $superficie = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_ajout = null;

    #[ORM\Column]
    private ?int $ProprietaireId = null;

    /**
     * @var Collection<int, AnnoncesColocation>
     */
    #[ORM\OneToMany(targetEntity: AnnoncesColocation::class, mappedBy: 'Logement')]
    private Collection $Annonces;

    public function __construct()
    {
        $this->Annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->Code_postal;
    }

    public function setCodePostal(?string $Code_postal): static
    {
        $this->Code_postal = $Code_postal;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): static
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function getProprietaireId(): ?int
    {
        return $this->ProprietaireId;
    }

    public function setProprietaireId(int $ProprietaireId): static
    {
        $this->ProprietaireId = $ProprietaireId;

        return $this;
    }

    /**
     * @return Collection<int, AnnoncesColocation>
     */
    public function getAnnonces(): Collection
    {
        return $this->Annonces;
    }

    public function addAnnonce(AnnoncesColocation $annonce): static
    {
        if (!$this->Annonces->contains($annonce)) {
            $this->Annonces->add($annonce);
            $annonce->setLogement($this);
        }

        return $this;
    }

    public function removeAnnonce(AnnoncesColocation $annonce): static
    {
        if ($this->Annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getLogement() === $this) {
                $annonce->setLogement(null);
            }
        }

        return $this;
    }
}
