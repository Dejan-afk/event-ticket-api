<?php

namespace App\Dto;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[UniqueEntity('email')]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 255)]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public string $lastname;
    
    #[Assert\Length(min: 2, max: 128)]
    public ?string $job = null;
}
