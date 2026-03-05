<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class TrackingEventData extends Data
{
    public function __construct(
        public readonly ?string $type = null,
        public readonly ?string $status = null,
        public readonly ?string $description = null,
        public readonly ?string $datetime = null,
        public readonly ?string $locationName = null,
    ) {}
}
