<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class TrackedShipmentData extends Data
{
    public function __construct(
        public readonly ?string $type = null,
    ) {}
}
