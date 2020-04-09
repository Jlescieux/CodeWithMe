<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CollaborationRepository")
 */
class Collaboration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOwner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $joinedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function __construct()
    {
        $this->joinedAt = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getisOwner(): ?bool
    {
        return $this->isOwner;
    }

    public function setisOwner(bool $isOwner): self
    {
        $this->isOwner = $isOwner;

        return $this;
    }

    public function getJoinedAt(): ?\DateTimeInterface
    {
        return $this->joinedAt;
    }

    public function setJoinedAt(\DateTimeInterface $joinedAt): self
    {
        $this->joinedAt = $joinedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
