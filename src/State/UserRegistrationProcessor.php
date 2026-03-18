<?php

namespace App\State;

use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Dto\UserRegistrationDto;

class UserRegistrationProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        if (!$data instanceof UserRegistrationDto) {
            throw new \InvalidArgumentException('Expected UserRegistrationDto.');
        }

        $user = new User();
        $user->setEmail($data->email);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setJob($data->job);
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());
        
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data->password);
        $user->setPassword($hashedPassword);

        return $this->persistProcessor->process($user, $operation, $uriVariables, $context);
    }
}
