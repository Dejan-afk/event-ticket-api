<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Repository\ProjectMemberRepository;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectMemberRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['project_member:read']],
    denormalizationContext: ['groups' => ['project_member:write']],
    operations: [
        new Get(
            security: 'is_granted("PROJECT_MEMBER_VIEW", object)'
        ),
        new Patch(
            security: 'is_granted("PROJECT_MEMBER_EDIT", object)'
        ),
        new Delete(
            security: 'is_granted("PROJECT_MEMBER_DELETE", object)'
        )
    ]
)]
class ProjectMember
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:read', 'project_member:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projectMembers')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    #[Groups(['project:read', 'project_member:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'projectMembers')]
    #[ORM\JoinColumn(name: 'project_id', nullable: false)]
    #[Groups(['project_member:read'])]
    private ?Project $project = null;

    #[ORM\Column(length: 128)]
    #[Groups(['project:read', 'project_member:read', 'project_member:write'])]
    private ?string $role = null;

    #[ORM\Column(name: 'created_at')]
    #[Groups(['project:read', 'project_member:read'])]
    private ?\DateTime $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
