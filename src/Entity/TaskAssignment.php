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
    private ?Task $task = null;

    #[ORM\ManyToOne(inversedBy: 'taskAssignments')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(name: 'assigned_at')]
    private ?\DateTime $assignedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): static
    {
        $this->task = $task;

        return $this;
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
