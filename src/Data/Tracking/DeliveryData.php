<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class DeliveryData extends Data
{
    public function __construct(
        public readonly ?string $recipientName = null,
        public readonly ?string $deliveryNotes = null,
    ) {}
}
