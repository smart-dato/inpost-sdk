<?php

namespace Smartdato\InPost\Data\Points;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class WeeklyOpeningHoursData extends Data
{
    /**
     * @param  list<OpeningPeriodData>|null  $monday
     * @param  list<OpeningPeriodData>|null  $tuesday
     * @param  list<OpeningPeriodData>|null  $wednesday
     * @param  list<OpeningPeriodData>|null  $thursday
     * @param  list<OpeningPeriodData>|null  $friday
     * @param  list<OpeningPeriodData>|null  $saturday
     * @param  list<OpeningPeriodData>|null  $sunday
     */
    public function __construct(
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $monday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $tuesday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $wednesday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $thursday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $friday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $saturday = null,
        #[DataCollectionOf(OpeningPeriodData::class)]
        public readonly ?array $sunday = null,
    ) {}
}
