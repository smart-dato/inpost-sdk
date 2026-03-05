<?php

namespace Smartdato\InPost\Requests\Pickups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListOneTimePickupsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $filters
     */
    public function __construct(
        protected readonly string $organizationId,
        protected readonly array $filters = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/one-time-pickups';
    }

    protected function defaultQuery(): array
    {
        return $this->filters;
    }
}
