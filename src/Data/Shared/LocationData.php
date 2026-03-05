<?php

namespace Smartdato\InPost\Data\Shared;

use Spatie\LaravelData\Data;

class LocationData extends Data
{
    public function __construct(
        public readonly ?string $pointId = null,
        public readonly ?AddressData $address = null,
    ) {}
}
