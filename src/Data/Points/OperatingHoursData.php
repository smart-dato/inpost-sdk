<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class OperatingHoursData extends Data
{
    public function __construct(
        public readonly ?WeeklyOpeningHoursData $customer = null,
    ) {}
}
