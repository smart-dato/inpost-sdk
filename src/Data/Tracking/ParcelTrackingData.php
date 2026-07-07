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
        public readonly ?array $events = null,
        public readonly ?EventLocationData $origin = null,
        public readonly ?EventLocationData $destination = null,
        public readonly ?DeliveryData $delivery = null,
        public readonly ?TrackedShipmentData $shipment = null,
        public readonly ?ReturnToSenderData $returnToSender = null,
    ) {}
}
