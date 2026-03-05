<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Smartdato\InPost\Data\Tracking\TrackResponseData;
use Smartdato\InPost\Requests\Tracking\TrackParcelsRequest;

class TrackingResource extends BaseResource
{
    /**
     * @param  list<string>  $trackingNumbers
     */
    public function track(array $trackingNumbers): TrackResponseData
    {
        $response = $this->connector->send(new TrackParcelsRequest($trackingNumbers));

        return TrackResponseData::from($response->json());
    }
}
