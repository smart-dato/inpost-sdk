<?php

namespace Smartdato\InPost\Data\Shipping;

use Spatie\LaravelData\Data;

class ReferencesData extends Data
{
    /**
     * @param  array<string, mixed>|null  $custom
     */
    public function __construct(
        public readonly ?string $reference = null,
        public readonly ?string $customerReference = null,
        public readonly ?array $custom = null,
    ) {}
}
