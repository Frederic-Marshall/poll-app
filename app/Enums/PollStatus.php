<?php

namespace App\Enums;

enum PollStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case CLOSED = 'closed';
}
