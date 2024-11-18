<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $discussions_id = null;

    #[ORM\Column]
    private ?int $expéditeur_id = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_envoi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscussionsId(): ?int
    {
        return $this->discussions_id;
    }

    public function setDiscussionsId(int $discussions_id): static
    {
        $this->discussions_id = $discussions_id;

        return $this;
    }

    public function getExpéditeurId(): ?int
    {
        return $this->expéditeur_id;
    }

    public function setExpéditeurId(int $expéditeur_id): static
    {
        $this->expéditeur_id = $expéditeur_id;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi(\DateTimeInterface $date_envoi): static
    {
        $this->date_envoi = $date_envoi;

        return $this;
    }
}
