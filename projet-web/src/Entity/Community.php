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
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\ManyToMany(targetEntity=Evenement::class, inversedBy="communities")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Follow::class, mappedBy="community")
     */
    private $follows;

    /**
     * @ORM\OneToMany(targetEntity=Organise::class, mappedBy="community")
     */
    private $organises;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->organises = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
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
     * @return Collection|Evenement[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Evenement $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Evenement $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }

    /**
     * @return Collection|Follow[]
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(Follow $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->setCommunity($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): self
    {
        if ($this->follows->removeElement($follow)) {
            // set the owning side to null (unless already changed)
            if ($follow->getCommunity() === $this) {
                $follow->setCommunity(null);
            }
        }

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
}
