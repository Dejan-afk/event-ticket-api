<?php

namespace App\Security\Voter;

use App\Entity\ProjectMember;
use App\Entity\User;
use App\Enum\ProjectMemberRole;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectMemberVoter extends Voter
{
    public const VIEW = 'PROJECT_MEMBER_VIEW';
    public const EDIT = 'PROJECT_MEMBER_EDIT';
    public const DELETE = 'PROJECT_MEMBER_DELETE';

    public function __construct(
        private Security $security
    ) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [
            self::VIEW,
            self::EDIT,
            self::DELETE,
        ], true) && $subject instanceof ProjectMember;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote=null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var ProjectMember $projectMember */
        $projectMember = $subject;
        $project = $projectMember->getProject();

        if (!$project) {
            return false;
        }

        $currentMembership = null;
        foreach ($project->getProjectMembers() as $membership) {
            if ($membership->getUser()?->getId() === $user->getId()) {
                $currentMembership = $membership;
                break;
            }
        }

        if (!$currentMembership) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => true,
            self::EDIT => $currentMembership->getRole() === ProjectMemberRole::OWNER->value,
            self::DELETE => $currentMembership->getRole() === ProjectMemberRole::OWNER->value,
            default => false,
        };
    }
}