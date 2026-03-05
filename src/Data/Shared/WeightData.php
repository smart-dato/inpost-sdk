<?php

namespace Smartdato\InPost\Data\Shared;

use Smartdato\InPost\Enums\WeightUnit;
use Spatie\LaravelData\Data;

class WeightData extends Data
{
    public function __construct(
        public readonly float $amount,
        public readonly WeightUnit $unit = WeightUnit::KG,
    ) {}
}
