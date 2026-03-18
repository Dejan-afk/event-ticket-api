<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Dto\UserRegistrationDto;
use App\State\UserRegistrationProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use App\State\CurrentUserProvider;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'email_unique', columns: ['email'])]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    operations: [
        new Post(
            uriTemplate: '/register',
            input: UserRegistrationDto::class,
            processor: UserRegistrationProcessor::class,
            security: 'is_granted("PUBLIC_ACCESS")',
        ),
        new Get(security: 'object == user or is_granted("ROLE_ADMIN")'),
        new GetCollection(security: 'is_granted("ROLE_ADMIN")'),
        new Get(
            uriTemplate: '/me',
            provider: CurrentUserProvider::class,
            security: 'is_granted("ROLE_USER")',
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Groups(['user:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[ApiProperty(readable: false, writable: false)]
    private ?string $password = null;

    #[ORM\Column(length: 128, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $job = null;

    #[ORM\Column]
    #[ApiProperty(readable: false, writable: false)]
    private array $roles = [];

    #[ORM\Column(name: "created_at")]
    #[Groups(['user:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: "updated_at")]
    #[Groups(['user:read'])]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, ProjectMember>
     */
    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $projectMembers;

    /**
     * @var Collection<int, TaskAssignment>
     */
    #[ORM\OneToMany(targetEntity: TaskAssignment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $taskAssignments;

    /**
     * @var Collection<int, TaskComment>
     */
    #[ORM\OneToMany(targetEntity: TaskComment::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $taskComments;

    public function __construct()
    {
        $this->projectMembers = new ArrayCollection();
        $this->taskAssignments = new ArrayCollection();
        $this->taskComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, ProjectMember>
     */
    public function getProjectMembers(): Collection
    {
        return $this->projectMembers;
    }

    public function addProjectMember(ProjectMember $projectMember): static
    {
        if (!$this->projectMembers->contains($projectMember)) {
            $this->projectMembers->add($projectMember);
            $projectMember->setUser($this);
        }

        return $this;
    }

    public function removeProjectMember(ProjectMember $projectMember): static
    {
        if ($this->projectMembers->removeElement($projectMember)) {
            // set the owning side to null (unless already changed)
            if ($projectMember->getUser() === $this) {
                $projectMember->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TaskAssignment>
     */
    public function getTaskAssignments(): Collection
    {
        return $this->taskAssignments;
    }

    public function addTaskAssignment(TaskAssignment $taskAssignment): static
    {
        if (!$this->taskAssignments->contains($taskAssignment)) {
            $this->taskAssignments->add($taskAssignment);
            $taskAssignment->setUser($this);
        }

        return $this;
    }

    public function removeTaskAssignment(TaskAssignment $taskAssignment): static
    {
        if ($this->taskAssignments->removeElement($taskAssignment)) {
            // set the owning side to null (unless already changed)
            if ($taskAssignment->getUser() === $this) {
                $taskAssignment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TaskComment>
     */
    public function getTaskComments(): Collection
    {
        return $this->taskComments;
    }

    public function addTaskComment(TaskComment $taskComment): static
    {
        if (!$this->taskComments->contains($taskComment)) {
            $this->taskComments->add($taskComment);
            $taskComment->setUser($this);
        }

        return $this;
    }

    public function removeTaskComment(TaskComment $taskComment): static
    {
        if ($this->taskComments->removeElement($taskComment)) {
            // set the owning side to null (unless already changed)
            if ($taskComment->getUser() === $this) {
                $taskComment->setUser(null);
            }
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
