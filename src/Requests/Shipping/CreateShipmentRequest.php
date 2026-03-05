<?php

namespace Smartdato\InPost\Requests\Shipping;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Smartdato\InPost\Data\Shipping\CreateShipmentData;

class CreateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly CreateShipmentData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/shipments';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
