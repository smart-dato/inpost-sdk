<?php

namespace Smartdato\InPost\Enums;

enum PickupStatus: string
{
    case REQUESTED = 'requested';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
