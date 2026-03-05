<?php

namespace Smartdato\InPost\Data\Shared;

use Spatie\LaravelData\Data;

class ContactData extends Data
{
    public function __construct(
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?string $companyName = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
    ) {}
}
