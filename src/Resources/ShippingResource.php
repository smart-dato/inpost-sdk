<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Smartdato\InPost\Data\Shared\LabelData;
use Smartdato\InPost\Data\Shipping\CreateShipmentData;
use Smartdato\InPost\Data\Shipping\ShipmentData;
use Smartdato\InPost\Enums\LabelFormat;
use Smartdato\InPost\Requests\Shipping\CreateShipmentRequest;
use Smartdato\InPost\Requests\Shipping\GetShipmentLabelRequest;
use Smartdato\InPost\Requests\Shipping\GetShipmentRequest;

class ShippingResource extends BaseResource
{
    public function __construct(
        \Saloon\Http\Connector $connector,
        protected readonly string $organizationId,
    ) {
        parent::__construct($connector);
    }

    public function create(CreateShipmentData $data): ShipmentData
    {
        $response = $this->connector->send(
            new CreateShipmentRequest($this->organizationId, $data)
        );

        return ShipmentData::from($response->json());
    }

    public function get(string $trackingNumber): ShipmentData
    {
        $response = $this->connector->send(
            new GetShipmentRequest($this->organizationId, $trackingNumber)
        );

        return ShipmentData::from($response->json());
    }

    public function label(string $trackingNumber, LabelFormat $format = LabelFormat::PDF): LabelData
    {
        $response = $this->connector->send(
            new GetShipmentLabelRequest($this->organizationId, $trackingNumber, $format)
        );

        return new LabelData(
            content: base64_encode($response->body()),
            contentType: $format->value,
        );
    }
}
