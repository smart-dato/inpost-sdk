<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class OpeningPeriodData extends Data
{
    public function __construct(
        public readonly ?string $start = null,
        public readonly ?string $end = null,
    ) {}
}
