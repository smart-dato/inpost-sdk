<?php

namespace Smartdato\InPost\Requests\Shipping;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetShipmentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly string $trackingNumber,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/shipments/'.$this->trackingNumber;
    }
}
