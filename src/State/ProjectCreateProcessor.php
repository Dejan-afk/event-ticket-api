<?php

namespace App\State;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\ProjectCreateDto;
use App\Entity\Project;
use App\Entity\ProjectMember;
use App\Enum\ProjectMemberRole;
use Symfony\Bundle\SecurityBundle\Security;
use App\Enum\DefaultBoardList;
use App\Entity\BoardList;

class ProjectCreateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Project
    {
        if (!$data instanceof ProjectCreateDto) {
            throw new \InvalidArgumentException('Expected ProjectCreateDto.');
        }

        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException('User must be authenticated to create a project.');
        }

        $now = new \DateTime();

        $project = new Project();
        $project->setTitle($data->title);
        $project->setDescription($data->description);
        $project->setDue( new \DateTime($data->due));
        $project->setPriority($data->priority);
        $project->setIsActive(true);
        $project->setCreatedAt($now);
        $project->setUpdatedAt($now);

        $projectMember = new ProjectMember();
        $projectMember->setProject($project);
        $projectMember->setUser($user);
        $projectMember->setRole(ProjectMemberRole::OWNER->value);
        $projectMember->setCreatedAt($now);

        $project->addProjectMember($projectMember);
        
        foreach(DefaultBoardList::cases() as $index => $defaultBoardList) {
            $boardList = new BoardList();
            $boardList->setProject($project);
            $boardList->setTitle($defaultBoardList->value);
            $boardList->setPosition($index);
            $boardList->setCreatedAt($now);
            $boardList->setUpdatedAt($now);
            $project->addBoardList($boardList);
        }

        return $this->persistProcessor->process($project, $operation, $uriVariables, $context);
    }
}