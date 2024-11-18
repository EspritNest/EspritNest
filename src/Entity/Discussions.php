<?php

namespace App\Entity;

use App\Repository\DiscussionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionsRepository::class)]
class Discussions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $utilisateur1_id = null;

    #[ORM\Column]
    private ?int $utilisateur2_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_At = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur1Id(): ?int
    {
        return $this->utilisateur1_id;
    }

    public function setUtilisateur1Id(int $utilisateur1_id): static
    {
        $this->utilisateur1_id = $utilisateur1_id;

        return $this;
    }

    public function getUtilisateur2Id(): ?int
    {
        return $this->utilisateur2_id;
    }

    public function setUtilisateur2Id(int $utilisateur2_id): static
    {
        $this->utilisateur2_id = $utilisateur2_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_At): static
    {
        $this->updated_At = $updated_At;

        return $this;
    }
}
