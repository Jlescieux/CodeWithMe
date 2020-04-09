<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbCollaborators;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbLikes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $urlFacebook;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $urlTwitter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $urlGithub;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $urlTipeee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSleeping;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Statut", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="project", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Request", mappedBy="project", orphanRemoval=true)
     */
    private $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Follow", mappedBy="project", orphanRemoval=true)
     */
    private $follows;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="projects")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Techno", inversedBy="projects")
     */
    private $technos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="projects")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Collaboration", mappedBy="project", orphanRemoval=true)
     */
    private $users;

    public function __construct()
    {
        $this->nbLikes = 0;
        $this->createdAt = new \Datetime();
        $this->isSleeping = 0;
        $this->isActive = 1;
        $this->comments = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->technos = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbCollaborators(): ?int
    {
        return $this->nbCollaborators;
    }

    public function setNbCollaborators(int $nbCollaborators): self
    {
        $this->nbCollaborators = $nbCollaborators;

        return $this;
    }

    public function getNbLikes(): ?int
    {
        return $this->nbLikes;
    }

    public function setNbLikes(int $nbLikes): self
    {
        $this->nbLikes = $nbLikes;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUrlFacebook(): ?string
    {
        return $this->urlFacebook;
    }

    public function setUrlFacebook(?string $urlFacebook): self
    {
        $this->urlFacebook = $urlFacebook;

        return $this;
    }

    public function getUrlTwitter(): ?string
    {
        return $this->urlTwitter;
    }

    public function setUrlTwitter(?string $urlTwitter): self
    {
        $this->urlTwitter = $urlTwitter;

        return $this;
    }

    public function getUrlGithub(): ?string
    {
        return $this->urlGithub;
    }

    public function setUrlGithub(?string $urlGithub): self
    {
        $this->urlGithub = $urlGithub;

        return $this;
    }

    public function getUrlTipeee(): ?string
    {
        return $this->urlTipeee;
    }

    public function setUrlTipeee(?string $urlTipeee): self
    {
        $this->urlTipeee = $urlTipeee;

        return $this;
    }

    public function getIsSleeping(): ?bool
    {
        return $this->isSleeping;
    }

    public function setIsSleeping(bool $isSleeping): self
    {
        $this->isSleeping = $isSleeping;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

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
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setProject($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->contains($request)) {
            $this->requests->removeElement($request);
            // set the owning side to null (unless already changed)
            if ($request->getProject() === $this) {
                $request->setProject(null);
            }
        }

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
            $follow->setProject($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): self
    {
        if ($this->follows->contains($follow)) {
            $this->follows->removeElement($follow);
            // set the owning side to null (unless already changed)
            if ($follow->getProject() === $this) {
                $follow->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|Techno[]
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function addTechno(Techno $techno): self
    {
        if (!$this->technos->contains($techno)) {
            $this->technos[] = $techno;
        }

        return $this;
    }

    public function removeTechno(Techno $techno): self
    {
        if ($this->technos->contains($techno)) {
            $this->technos->removeElement($techno);
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    /**
     * @return Collection|Collaboration[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Collaboration $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProject($this);
        }

        return $this;
    }

    public function removeUser(Collaboration $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getProject() === $this) {
                $user->setProject(null);
            }
        }

        return $this;
    }
}
