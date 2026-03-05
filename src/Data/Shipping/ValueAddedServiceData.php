<?php

namespace Smartdato\InPost\Data\Shipping;

use Spatie\LaravelData\Data;

class ValueAddedServiceData extends Data
{
    public function __construct(
        public readonly string $type,
        /** @var array<string, mixed>|null */
        public readonly ?array $parameters = null,
    ) {}
}
