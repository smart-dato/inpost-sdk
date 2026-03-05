<?php

namespace Smartdato\InPost\Data\Shipping;

use Spatie\LaravelData\Data;

class CustomsClearanceData extends Data
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $currency = null,
        public readonly ?float $declaredValue = null,
        public readonly ?string $incoterms = null,
        /** @var list<array<string, mixed>>|null */
        public readonly ?array $items = null,
    ) {}
}
