<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class TrackingEventData extends Data
{
    public function __construct(
        public readonly ?string $eventTimestamp = null,
        public readonly ?string $eventCode = null,
        public readonly ?string $status = null,
        public readonly ?string $eventId = null,
        public readonly ?EventLocationData $location = null,
    ) {}
}
