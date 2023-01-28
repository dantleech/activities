<?php

namespace Activities\Activities\Model;

enum ActivityType: string
{
    case WALK = 'walk';
    case RUN = 'run';
    case CYCLE = 'cycle';
    case SWIM = 'swim';
    case OTHER = 'other';
}
