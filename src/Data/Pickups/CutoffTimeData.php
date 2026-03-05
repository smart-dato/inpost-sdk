<?php

namespace Smartdato\InPost\Data\Pickups;

use Spatie\LaravelData\Data;

class CutoffTimeData extends Data
{
    public function __construct(
        public readonly ?string $cutoffTime = null,
        public readonly ?string $pickupDate = null,
    ) {}
}
