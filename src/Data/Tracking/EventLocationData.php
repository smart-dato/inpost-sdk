<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class EventLocationData extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $country = null,
        public readonly ?string $name = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $type = null,
        public readonly ?string $description = null,
    ) {}
}
