<?php

namespace Smartdato\InPost\Requests\Shipping;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Smartdato\InPost\Enums\LabelFormat;

class GetShipmentLabelRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly string $trackingNumber,
        protected readonly LabelFormat $format = LabelFormat::PDF,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/shipments/'.$this->trackingNumber.'/label';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => $this->format->value,
        ];
    }
}
