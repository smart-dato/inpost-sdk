<?php

namespace Smartdato\InPost\Data\Returns;

use Spatie\LaravelData\Data;

class ReturnLabelData extends Data
{
    public function __construct(
        public readonly string $content,
        public readonly string $contentType,
    ) {}
}
