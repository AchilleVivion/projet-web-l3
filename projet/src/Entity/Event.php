<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="events")
     */
    private $participants;

    /**
     * @ORM\ManyToMany(targetEntity=Community::class, inversedBy="events")
     */
    private $communities;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="theEvent")
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->communities = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * @return Collection|Community[]
     */
    public function getCommunities(): Collection
    {
        return $this->communities;
    }

    public function addCommunity(Community $community): self
    {
        if (!$this->communities->contains($community)) {
            $this->communities[] = $community;
        }

        return $this;
    }

    public function removeCommunity(Community $community): self
    {
        $this->communities->removeElement($community);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTheEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTheEvent() === $this) {
                $comment->setTheEvent(null);
            }
        }

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
