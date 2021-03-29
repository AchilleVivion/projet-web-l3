<?php

namespace App\Entity;

use App\Repository\CommunityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunityRepository::class)
 */
class Community
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\OneToMany(targetEntity=Organise::class, mappedBy="community", cascade={"persist"})
     */
    private $organises;

    /**
     * @ORM\OneToMany(targetEntity=Follow::class, mappedBy="community", cascade={"persist"})
     */
    private $followedby;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="communities", cascade={"persist"})
     */
    private $events;

    public function __construct()
    {
        $this->organises = new ArrayCollection();
        $this->followedby = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return Collection|Organise[]
     */
    public function getOrganises(): Collection
    {
        return $this->organises;
    }

    public function addOrganise(Organise $organise): self
    {
        if (!$this->organises->contains($organise)) {
            $this->organises[] = $organise;
            $organise->setCommunity($this);
        }

        return $this;
    }

    public function removeOrganise(Organise $organise): self
    {
        if ($this->organises->removeElement($organise)) {
            // set the owning side to null (unless already changed)
            if ($organise->getCommunity() === $this) {
                $organise->setCommunity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Follow[]
     */
    public function getFollowedby(): Collection
    {
        return $this->followedby;
    }

    public function addFollowedby(Follow $followedby): self
    {
        if (!$this->followedby->contains($followedby)) {
            $this->followedby[] = $followedby;
            $followedby->setCommunity($this);
        }

        return $this;
    }

    public function removeFollowedby(Follow $followedby): self
    {
        if ($this->followedby->removeElement($followedby)) {
            // set the owning side to null (unless already changed)
            if ($followedby->getCommunity() === $this) {
                $followedby->setCommunity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addCommunity($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeCommunity($this);
        }

        return $this;
    }
}
