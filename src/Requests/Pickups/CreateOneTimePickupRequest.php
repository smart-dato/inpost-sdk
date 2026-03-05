<?php

namespace Smartdato\InPost\Requests\Pickups;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Smartdato\InPost\Data\Pickups\CreateOneTimePickupData;

class CreateOneTimePickupRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $organizationId,
        protected readonly CreateOneTimePickupData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/one-time-pickups';
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
