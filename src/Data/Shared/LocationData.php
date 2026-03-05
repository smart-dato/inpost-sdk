<?php

namespace Smartdato\InPost\Data\Shared;

use Spatie\LaravelData\Data;

class LocationData extends Data
{
    /**
     * @param  list<string>|null  $shippingMethods
     */
    public function __construct(
        public readonly ?string $countryCode = null,
        public readonly ?string $pointId = null,
        public readonly ?string $street = null,
        public readonly ?string $city = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $shippingMethod = null,
        public readonly ?array $shippingMethods = null,
    ) {}
}
