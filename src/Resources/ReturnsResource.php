<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Smartdato\InPost\Data\Returns\CreateReturnShipmentData;
use Smartdato\InPost\Data\Returns\ReturnShipmentData;
use Smartdato\InPost\Data\Shared\LabelData;
use Smartdato\InPost\Enums\LabelFormat;
use Smartdato\InPost\Requests\Returns\CreateReturnShipmentRequest;
use Smartdato\InPost\Requests\Returns\GetReturnLabelRequest;
use Smartdato\InPost\Requests\Returns\GetReturnShipmentRequest;

class ReturnsResource extends BaseResource
{
    public function __construct(
        \Saloon\Http\Connector $connector,
        protected readonly string $organizationId,
    ) {
        parent::__construct($connector);
    }

    public function create(CreateReturnShipmentData $data): ReturnShipmentData
    {
        $response = $this->connector->send(
            new CreateReturnShipmentRequest($this->organizationId, $data)
        );

        return ReturnShipmentData::from($response->json());
    }

    public function get(string $shipmentId): ReturnShipmentData
    {
        $response = $this->connector->send(
            new GetReturnShipmentRequest($this->organizationId, $shipmentId)
        );

        return ReturnShipmentData::from($response->json());
    }

    public function label(string $shipmentId, LabelFormat $format = LabelFormat::PDF): LabelData
    {
        $response = $this->connector->send(
            new GetReturnLabelRequest($this->organizationId, $shipmentId, $format)
        );

        return new LabelData(
            content: base64_encode($response->body()),
            contentType: $format->value,
        );
    }
}
