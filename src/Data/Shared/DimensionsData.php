<?php

namespace Smartdato\InPost\Data\Shared;

use Smartdato\InPost\Enums\DimensionUnit;
use Spatie\LaravelData\Data;

class DimensionsData extends Data
{
    public function __construct(
        public readonly float $length,
        public readonly float $width,
        public readonly float $height,
        public readonly DimensionUnit $unit = DimensionUnit::MM,
    ) {}
}
