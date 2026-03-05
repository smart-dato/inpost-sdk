<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class ParcelTrackingData extends Data
{
    /**
     * @param  list<TrackingEventData>|null  $events
     */
    public function __construct(
        public readonly ?string $trackingNumber = null,
        public readonly ?string $status = null,
        public readonly ?string $service = null,
        public readonly ?array $events = null,
    ) {}
}
