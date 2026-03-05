<?php

namespace Smartdato\InPost\Data\Shipping;

use Smartdato\InPost\Data\Shared\ContactData;
use Smartdato\InPost\Data\Shared\LocationData;
use Spatie\LaravelData\Data;

class ShipmentData extends Data
{
    /**
     * @param  list<ParcelData>|null  $parcels
     * @param  list<ValueAddedServiceData>|null  $valueAddedServices
     */
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $status = null,
        public readonly ?string $trackingNumber = null,
        public readonly ?ContactData $sender = null,
        public readonly ?ContactData $recipient = null,
        public readonly ?LocationData $origin = null,
        public readonly ?LocationData $destination = null,
        public readonly ?array $parcels = null,
        public readonly ?ReferencesData $references = null,
        public readonly ?array $valueAddedServices = null,
        public readonly ?CustomsClearanceData $customsClearance = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}
}
