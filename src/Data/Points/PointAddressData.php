<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class PointAddressData extends Data
{
    public function __construct(
        public readonly ?string $country = null,
        public readonly ?string $administrativeArea = null,
        public readonly ?string $city = null,
        public readonly ?string $street = null,
        public readonly ?string $buildingNumber = null,
        public readonly ?string $postalCode = null,
    ) {}
}
