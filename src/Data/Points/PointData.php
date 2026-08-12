<?php

namespace Smartdato\InPost\Data\Points;

use Smartdato\InPost\Enums\PointType;
use Spatie\LaravelData\Data;

class PointData extends Data
{
    /**
     * @param  list<string>|null  $capabilities
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $displayName = null,
        public readonly ?PointType $type = null,
        public readonly ?string $country = null,
        public readonly ?PointAddressData $address = null,
        public readonly ?CoordinatesData $coordinates = null,
        public readonly ?PointDescriptionData $description = null,
        public readonly ?PointDescriptionData $description2 = null,
        public readonly ?PointDescriptionData $description3 = null,
        public readonly ?OperatingHoursData $operatingHours = null,
        public readonly ?array $capabilities = null,
        public readonly ?string $imageUrl = null,
        public readonly ?string $locationType = null,
        public readonly ?bool $location247 = null,
    ) {}
}
