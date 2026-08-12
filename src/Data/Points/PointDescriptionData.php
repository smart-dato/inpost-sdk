<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class PointDescriptionData extends Data
{
    /**
     * @param  array<string, string>|null  $translations
     */
    public function __construct(
        public readonly ?string $content = null,
        public readonly ?array $translations = null,
    ) {}
}
