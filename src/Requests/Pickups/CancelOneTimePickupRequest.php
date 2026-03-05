<?php

namespace Smartdato\InPost\Requests\Pickups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CancelOneTimePickupRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly string $orderId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/one-time-pickups/'.$this->orderId;
    }
}
