<?php

namespace App\Entity;

use App\Repository\TaskAssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskAssignmentRepository::class)]
class TaskAssignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'taskAssignments')]
    #[ORM\JoinColumn(name: 'task_id', nullable: false)]
    private ?Task $taskId = null;

    #[ORM\ManyToOne(inversedBy: 'taskAssignments')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(name: 'assigned_at')]
    private ?\DateTime $assignedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskId(): ?Task
    {
        return $this->taskId;
    }

    public function setTaskId(?Task $taskId): static
    {
        $this->taskId = $taskId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAssignedAt(): ?\DateTime
    {
        return $this->assignedAt;
    }

    public function setAssignedAt(\DateTime $assignedAt): static
    {
        $this->assignedAt = $assignedAt;

        return $this;
    }
}
