<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class CoordinatesData extends Data
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {}
}
