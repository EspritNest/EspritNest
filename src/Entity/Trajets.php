<?php

namespace App\Entity;

use App\Repository\TrajetsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetsRepository::class)]
class Trajets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $conducteurId = null;

    #[ORM\Column]
    private ?int $voitureId = null;

    #[ORM\Column(length: 255)]
    private ?string $pointDepart = null;

    #[ORM\Column(length: 255)]
    private ?string $pointDarrivee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column]
    private ?int $nombrePlaceDispo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'trajets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voitures $voitures = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureDepart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getConducteurId(): ?int
    {
        return $this->conducteurId;
    }

    public function setConducteurId(int $conducteurId): static
    {
        $this->conducteurId = $conducteurId;

        return $this;
    }

    public function getVoitureId(): ?int
    {
        return $this->voitureId;
    }

    public function setVoitureId(int $voitureId): static
    {
        $this->voitureId = $voitureId;

        return $this;
    }

    public function getPointDepart(): ?string
    {
        return $this->pointDepart;
    }

    public function setPointDepart(string $pointDepart): static
    {
        $this->pointDepart = $pointDepart;

        return $this;
    }

    public function getPointDarrivee(): ?string
    {
        return $this->pointDarrivee;
    }

    public function setPointDarrivee(string $pointDarrivee): static
    {
        $this->pointDarrivee = $pointDarrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNombrePlaceDispo(): ?int
    {
        return $this->nombrePlaceDispo;
    }

    public function setNombrePlaceDispo(int $nombrePlaceDispo): static
    {
        $this->nombrePlaceDispo = $nombrePlaceDispo;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getVoitures(): ?voitures
    {
        return $this->voitures;
    }

    public function setVoitures(?voitures $voitures): static
    {
        $this->voitures = $voitures;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $heureDepart): static
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }
}
