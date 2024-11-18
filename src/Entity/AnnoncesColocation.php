<?php

namespace App\Entity;

use App\Repository\AnnoncesColocationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnoncesColocationRepository::class)]
class AnnoncesColocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $maison_id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nombre_chambres = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_pub = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaisonId(): ?int
    {
        return $this->maison_id;
    }

    public function setMaisonId(int $maison_id): static
    {
        $this->maison_id = $maison_id;

        return $this;
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
}
