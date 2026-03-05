<?php

namespace Smartdato\InPost\Data\Pickups;

use Smartdato\InPost\Data\Shared\AddressData;
use Smartdato\InPost\Enums\PickupStatus;
use Spatie\LaravelData\Data;

class OneTimePickupData extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?PickupStatus $status = null,
        public readonly ?string $type = null,
        public readonly ?AddressData $address = null,
        public readonly ?ContactPersonData $contactPerson = null,
        public readonly ?PickupTimeData $pickupTime = null,
        public readonly ?int $parcelCount = null,
        public readonly ?string $comment = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}
}
