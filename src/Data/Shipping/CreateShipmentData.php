<?php

namespace Smartdato\InPost\Data\Shipping;

use Smartdato\InPost\Data\Shared\ContactData;
use Smartdato\InPost\Data\Shared\LocationData;
use Spatie\LaravelData\Data;

class CreateShipmentData extends Data
{
    /**
     * @param  list<ParcelData>  $parcels
     * @param  list<ValueAddedServiceData>|null  $valueAddedServices
     */
    public function __construct(
        public readonly ContactData $sender,
        public readonly ContactData $recipient,
        public readonly LocationData $origin,
        public readonly LocationData $destination,
        public readonly array $parcels,
        public readonly ?ReferencesData $references = null,
        public readonly ?array $valueAddedServices = null,
        public readonly ?CustomsClearanceData $customsClearance = null,
    ) {}
}
