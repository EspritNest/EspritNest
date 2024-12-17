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
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $sentAt;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private Utilisateur $sender;

    #[ORM\ManyToOne(targetEntity: Discussions::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private Discussions $discussion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): static
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getSender(): ?Utilisateur
    {
        return $this->sender;
    }

    public function setSender(Utilisateur $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getDiscussion(): ?Discussions
    {
        return $this->discussion;
    }

    public function setDiscussion(Discussions $discussion): static
    {
        $this->discussion = $discussion;

        return $this;
    }
}
