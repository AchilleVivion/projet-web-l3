<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FollowRepository::class)
 */
class Follow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Community::class, inversedBy="followedby")
     */
    private $community;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="follows")
     */
    private $theuser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommunity(): ?Community
    {
        return $this->community;
    }

    public function setCommunity(?Community $community): self
    {
        $this->community = $community;

        return $this;
    }

    public function getTheuser(): ?User
    {
        return $this->theuser;
    }

    public function setTheuser(?User $theuser): self
    {
        $this->theuser = $theuser;

        return $this;
    }
}