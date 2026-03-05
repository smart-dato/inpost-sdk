<?php

namespace Smartdato\InPost\Data\Pickups;

use Spatie\LaravelData\Data;

class PickupTimeData extends Data
{
    public function __construct(
        public readonly string $date,
        public readonly ?string $timeFrom = null,
        public readonly ?string $timeTo = null,
    ) {}
}
