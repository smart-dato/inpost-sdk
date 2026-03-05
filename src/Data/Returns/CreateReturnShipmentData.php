<?php

namespace Smartdato\InPost\Data\Returns;

use Smartdato\InPost\Data\Shared\AddressData;
use Spatie\LaravelData\Data;

class CreateReturnShipmentData extends Data
{
    public function __construct(
        public readonly string $senderName,
        public readonly string $senderEmail,
        public readonly ?string $senderPhone = null,
        public readonly ?AddressData $senderAddress = null,
        public readonly ?string $destinationPointId = null,
        public readonly ?string $originPointId = null,
        public readonly ?string $reference = null,
    ) {}
}
