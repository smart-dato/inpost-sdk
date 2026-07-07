<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Smartdato\InPost\Data\Tracking\TrackResponseData;
use Smartdato\InPost\Requests\Tracking\TrackParcelsRequest;

class TrackingResource extends BaseResource
{
    /**
     * @param  list<string>  $trackingNumbers
     */
    public function track(array $trackingNumbers): TrackResponseData
    {
        return TrackResponseData::from($this->trackRaw($trackingNumbers)->json());
    }

    /**
     * @param  list<string>  $trackingNumbers
     */
    public function trackRaw(array $trackingNumbers): Response
    {
        return $this->connector->send(new TrackParcelsRequest($trackingNumbers));
    }
}
