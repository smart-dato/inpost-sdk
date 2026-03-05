<?php

namespace Smartdato\InPost\Data\Shipping;

use Smartdato\InPost\Data\Shared\DimensionsData;
use Smartdato\InPost\Data\Shared\WeightData;
use Spatie\LaravelData\Data;

class ParcelData extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $type = null,
        public readonly ?DimensionsData $dimensions = null,
        public readonly ?WeightData $weight = null,
        public readonly ?string $trackingNumber = null,
    ) {}
}
