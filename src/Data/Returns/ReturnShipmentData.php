<?php

namespace Smartdato\InPost\Data\Returns;

use Spatie\LaravelData\Data;

class ReturnShipmentData extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $status = null,
        public readonly ?string $trackingNumber = null,
        public readonly ?string $senderName = null,
        public readonly ?string $senderEmail = null,
        public readonly ?string $senderPhone = null,
        public readonly ?string $originPointId = null,
        public readonly ?string $destinationPointId = null,
        public readonly ?string $reference = null,
        public readonly ?string $expirationDate = null,
        public readonly ?string $createdAt = null,
    ) {}
}
