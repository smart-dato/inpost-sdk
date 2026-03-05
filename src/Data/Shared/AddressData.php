<?php

namespace Smartdato\InPost\Data\Shared;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public readonly ?string $street = null,
        public readonly ?string $buildingNumber = null,
        public readonly ?string $city = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $countryCode = null,
    ) {}
}
