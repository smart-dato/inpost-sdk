<?php

namespace Smartdato\InPost\Requests\Points;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchPointsByLocationRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        protected readonly float $latitude,
        protected readonly float $longitude,
        protected readonly ?float $distance = null,
        protected readonly array $filters = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/points';
    }

    protected function defaultQuery(): array
    {
        $query = array_merge($this->filters, [
            'relative_point' => $this->latitude.','.$this->longitude,
        ]);

        if ($this->distance !== null) {
            $query['distance'] = $this->distance;
        }

        return $query;
    }
}
