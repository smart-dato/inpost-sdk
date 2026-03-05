<?php

namespace Smartdato\InPost\Data\Shared;

use Spatie\LaravelData\Data;

class LabelData extends Data
{
    public function __construct(
        public readonly string $content,
        public readonly string $contentType,
    ) {}
}
