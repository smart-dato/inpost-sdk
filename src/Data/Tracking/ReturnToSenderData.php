<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class ReturnToSenderData extends Data
{
    public function __construct(
        public readonly ?string $trackingNumber = null,
    ) {}
}
