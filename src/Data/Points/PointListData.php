<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Data;

class PointListData extends Data
{
    /**
     * @param  list<PointData>  $items
     */
    public function __construct(
        public readonly array $items,
        public readonly ?int $totalItems = null,
        public readonly ?int $page = null,
        public readonly ?int $perPage = null,
    ) {}
}
