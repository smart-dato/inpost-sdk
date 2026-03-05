<?php

namespace Smartdato\InPost\Requests\Returns;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Smartdato\InPost\Data\Returns\CreateReturnShipmentData;

class CreateReturnShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly CreateReturnShipmentData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/returns';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
