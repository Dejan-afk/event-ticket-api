<?php

namespace App\Dto;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectCreateDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 128)]
    #[Groups(['project:write'])]
    public string $title;

    #[Assert\Length(max: 65535)]
    #[Groups(['project:write'])]
    public ?string $description = null;

    #[Assert\DateTime(format: \DateTimeInterface::ATOM)]
    #[Groups(['project:write'])]
    public ?string $due = null;

    #[Assert\Length(max: 255)]
    #[Groups(['project:write'])]
    public ?string $priority = null;
}