<?php

namespace Smartdato\InPost\Requests\Points;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListPointsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        protected readonly array $filters = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/points';
    }

    protected function defaultQuery(): array
    {
        return $this->filters;
    }
}
