<?php

namespace Smartdato\InPost\Requests\Pickups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCutoffTimeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $postalCode,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/cutoff-times';
    }

    protected function defaultQuery(): array
    {
        return [
            'postalCode' => $this->postalCode,
        ];
    }
}
