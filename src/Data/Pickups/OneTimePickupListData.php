<?php

namespace Smartdato\InPost\Data\Pickups;

use Spatie\LaravelData\Data;

class OneTimePickupListData extends Data
{
    /**
     * @param  list<OneTimePickupData>  $items
     */
    public function __construct(
        public readonly array $items,
        public readonly ?int $totalItems = null,
        public readonly ?int $page = null,
        public readonly ?int $perPage = null,
    ) {}
}
