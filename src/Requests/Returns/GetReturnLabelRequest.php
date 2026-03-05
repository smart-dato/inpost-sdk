<?php

namespace Smartdato\InPost\Requests\Returns;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Smartdato\InPost\Enums\LabelFormat;

class GetReturnLabelRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly string $shipmentId,
        protected readonly LabelFormat $format = LabelFormat::PDF,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/returns/'.$this->shipmentId.'/label';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => $this->format->value,
        ];
    }
}
