<?php

namespace App\Entity;

use App\Repository\DiscussionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionsRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_participants', columns: ['participant1_id', 'participant2_id'])]
class Discussions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'discussionsAsParticipant1')]
    #[ORM\JoinColumn(nullable: false)]
    private Utilisateur $participant1;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'discussionsAsParticipant2')]
    #[ORM\JoinColumn(nullable: false)]
    private Utilisateur $participant2;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'discussion')]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->updated_At = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipant1(): ?Utilisateur
    {
        return $this->participant1;
    }

    public function setParticipant1(Utilisateur $participant1): static
    {
        $this->participant1 = $participant1;

        return $this;
    }

    public function getParticipant2(): ?Utilisateur
    {
        return $this->participant2;
    }

    public function setParticipant2(Utilisateur $participant2): static
    {
        $this->participant2 = $participant2;

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
            $message->setDiscussion($this);
        }

        return $this;
    }

    public function getUtilisateur2Id(): ?int
    {
        return $this->participant2->getId();
    }

    public function getOtherParticipant(Utilisateur $currentUser): ?Utilisateur
    {
        return $this->participant1 === $currentUser ? $this->participant2 : $this->participant1;
    }

    public function getLastMessage(): ?Messages
    {
        return $this->messages->last() ?: null;
    }
}
