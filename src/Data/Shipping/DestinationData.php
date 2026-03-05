<?php

namespace Smartdato\InPost\Data\Shipping;

use Smartdato\InPost\Data\Shared\AddressData;
use Spatie\LaravelData\Data;

class DestinationData extends Data
{
    public function __construct(
        public readonly ?string $pointId = null,
        public readonly ?AddressData $address = null,
    ) {}
}
