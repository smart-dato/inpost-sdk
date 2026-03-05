<?php

namespace Smartdato\InPost\Requests\Tracking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class TrackParcelsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  list<string>  $trackingNumbers
     */
    public function __construct(
        protected readonly array $trackingNumbers,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/parcels';
    }

    protected function defaultQuery(): array
    {
        return [
            'trackingNumbers' => implode(',', $this->trackingNumbers),
        ];
    }
}
