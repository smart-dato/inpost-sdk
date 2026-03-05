<?php

namespace Smartdato\InPost\Data\Shipping;

use Smartdato\InPost\Data\Shared\AddressData;
use Spatie\LaravelData\Data;

class SenderData extends Data
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $companyName = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?AddressData $address = null,
    ) {}
}
