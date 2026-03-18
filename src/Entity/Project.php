<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Dto\ProjectCreateDto;
use App\State\ProjectCreateProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['project:read']],
    denormalizationContext: ['groups' => ['project:write']],
    operations: [
        new Post(
            security: 'is_granted("ROLE_USER")',
            input: ProjectCreateDto::class,
            processor: ProjectCreateProcessor::class
        ),
        new GetCollection(
            security: 'is_granted("ROLE_USER")'
        ),
        new Get(
            security: 'is_granted("ROLE_USER")'
        ),
        new Patch(
            security: 'is_granted("PROJECT_EDIT", object)'
        ),
        new Delete(
            security: 'is_granted("PROJECT_DELETE", object)'
        )
    ]
)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['project:read', 'project:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['project:read', 'project:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['project:read', 'project:write'])]
    private ?\DateTime $due = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['project:read', 'project:write'])]
    private ?string $priority = null;

    #[ORM\Column(name: 'is_active')]
    #[Groups(['project:read'])]
    private ?bool $isActive = null;

    #[ORM\Column(name: 'created_at')]
    #[Groups(['project:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(name: 'updated_at')]
    #[Groups(['project:read'])]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, BoardList>
     */
    #[ORM\OneToMany(targetEntity: BoardList::class, mappedBy: 'project', orphanRemoval: true, cascade: ['persist'])]
    #[Groups(['project:read'])]
    private Collection $boardLists;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'project', orphanRemoval: true)]
    private Collection $tasks;

    /**
     * @var Collection<int, ProjectMember>
     */
    #[ORM\OneToMany(targetEntity: ProjectMember::class, mappedBy: 'project', orphanRemoval: true, cascade: ['persist'])]
    #[Groups(['project:read'])]
    private Collection $projectMembers;

    public function __construct()
    {
        $this->boardLists = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->projectMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDue(): ?\DateTime
    {
        return $this->due;
    }

    public function setDue(\DateTime $due): static
    {
        $this->due = $due;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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
     * @return Collection<int, BoardList>
     */
    public function getBoardLists(): Collection
    {
        return $this->boardLists;
    }

    public function addBoardList(BoardList $boardList): static
    {
        if (!$this->boardLists->contains($boardList)) {
            $this->boardLists->add($boardList);
            $boardList->setProject($this);
        }

        return $this;
    }

    public function removeBoardList(BoardList $boardList): static
    {
        if ($this->boardLists->removeElement($boardList)) {
            // set the owning side to null (unless already changed)
            if ($boardList->getProject() === $this) {
                $boardList->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

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
            $projectMember->setProject($this);
        }

        return $this;
    }

    public function removeProjectMember(ProjectMember $projectMember): static
    {
        if ($this->projectMembers->removeElement($projectMember)) {
            // set the owning side to null (unless already changed)
            if ($projectMember->getProject() === $this) {
                $projectMember->setProject(null);
            }
        }

        return $this;
    }
}
