<?php

namespace Smartdato\InPost\Requests\Points;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPointRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $pointId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/points/'.$this->pointId;
    }
}
