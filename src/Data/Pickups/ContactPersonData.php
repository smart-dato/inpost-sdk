<?php

namespace Smartdato\InPost\Data\Pickups;

use Spatie\LaravelData\Data;

class ContactPersonData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
    ) {}
}
