<?php

namespace Smartdato\InPost\Data\Points;

use Smartdato\InPost\Data\Shared\AddressData;
use Smartdato\InPost\Enums\PointType;
use Spatie\LaravelData\Data;

class PointData extends Data
{
    /**
     * @param  list<string>|null  $capabilities
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?PointType $type = null,
        public readonly ?string $status = null,
        public readonly ?AddressData $address = null,
        public readonly ?CoordinatesData $coordinates = null,
        public readonly ?OperatingHoursData $operatingHours = null,
        public readonly ?array $capabilities = null,
        public readonly ?string $imageUrl = null,
    ) {}
}
