<?php

namespace Smartdato\InPost\Data\Tracking;

use Spatie\LaravelData\Data;

class TrackResponseData extends Data
{
    /**
     * @param  list<ParcelTrackingData>  $parcels
     */
    public function __construct(
        public readonly array $parcels,
    ) {}
}
