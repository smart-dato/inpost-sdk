<?php

namespace Smartdato\InPost\Data\Shipping;

use Spatie\LaravelData\Data;

class LabelData extends Data
{
    public function __construct(
        public readonly string $content,
        public readonly string $contentType,
    ) {}
}
