<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class OperatingHoursData extends Data
{
    public function __construct(
        public readonly ?string $monday = null,
        public readonly ?string $tuesday = null,
        public readonly ?string $wednesday = null,
        public readonly ?string $thursday = null,
        public readonly ?string $friday = null,
        public readonly ?string $saturday = null,
        public readonly ?string $sunday = null,
    ) {}
}
