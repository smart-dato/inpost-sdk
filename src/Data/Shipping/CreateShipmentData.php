<?php

namespace Smartdato\InPost\Data\Shipping;

use Spatie\LaravelData\Data;

class CreateShipmentData extends Data
{
    /**
     * @param  list<ParcelData>  $parcels
     * @param  list<ValueAddedServiceData>|null  $valueAddedServices
     */
    public function __construct(
        public readonly SenderData $sender,
        public readonly RecipientData $recipient,
        public readonly OriginData $origin,
        public readonly DestinationData $destination,
        public readonly array $parcels,
        public readonly ?ReferencesData $references = null,
        public readonly ?array $valueAddedServices = null,
        public readonly ?CustomsClearanceData $customsClearance = null,
    ) {}
}
