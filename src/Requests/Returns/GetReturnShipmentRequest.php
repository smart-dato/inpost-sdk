<?php

namespace Smartdato\InPost\Requests\Returns;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetReturnShipmentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly string $shipmentId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/returns/'.$this->shipmentId;
    }
}
