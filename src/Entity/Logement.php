<?php

namespace App\Entity;

use App\Repository\LogementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogementRepository::class)]
class Logement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Propriétaire_id = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropriétaireId(): ?int
    {
        return $this->Propriétaire_id;
    }

    public function setPropriétaireId(int $Propriétaire_id): static
    {
        $this->Propriétaire_id = $Propriétaire_id;

        return $this;
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
}
