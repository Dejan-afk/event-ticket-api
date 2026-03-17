<?php
namespace App\Enum;

enum ProjectMemberRole: string 
{
    case OWNER = 'owner';
    case CONTRIBUTOR = 'contributor';
}