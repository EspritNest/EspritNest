<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $commentt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateC = null;

    #[ORM\ManyToOne(targetEntity: AnnoncesColocation::class)]
    #[ORM\JoinColumn(name: "log_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Annoncescolocation $Annonce = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Utilisateur $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentt(): ?string
    {
        return $this->commentt;
    }

    public function setCommentt(string $commentt): static
    {
        $this->commentt = $commentt;

        return $this;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->dateC;
    }

    public function setDateC(\DateTimeInterface $dateC): static
    {
        $this->dateC = $dateC;

        return $this;
    }

    public function getAnnonce(): ?Annoncescolocation
    {
        return $this->Annonce;
    }

    public function setAnnonce(?Annoncescolocation $Annonce): static
    {
        $this->Annonce = $Annonce;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): static
    {
        $this->user = $user;

        return $this;
    }
}
