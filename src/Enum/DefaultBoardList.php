<?php

namespace App\Enum;

enum DefaultBoardList: string
{
    case TODO = 'TODO';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';
}