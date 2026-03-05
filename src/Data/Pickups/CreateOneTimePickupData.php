<?php

namespace Smartdato\InPost\Data\Pickups;

use Smartdato\InPost\Data\Shared\AddressData;
use Spatie\LaravelData\Data;

class CreateOneTimePickupData extends Data
{
    public function __construct(
        public readonly AddressData $address,
        public readonly ContactPersonData $contactPerson,
        public readonly PickupTimeData $pickupTime,
        public readonly ?string $type = null,
        public readonly ?int $parcelCount = null,
        public readonly ?string $comment = null,
    ) {}
}
