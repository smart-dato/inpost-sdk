<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Smartdato\InPost\Data\Pickups\CreateOneTimePickupData;
use Smartdato\InPost\Data\Pickups\CutoffTimeData;
use Smartdato\InPost\Data\Pickups\OneTimePickupData;
use Smartdato\InPost\Data\Pickups\OneTimePickupListData;
use Smartdato\InPost\Requests\Pickups\CancelOneTimePickupRequest;
use Smartdato\InPost\Requests\Pickups\CreateOneTimePickupRequest;
use Smartdato\InPost\Requests\Pickups\GetCutoffTimeRequest;
use Smartdato\InPost\Requests\Pickups\GetOneTimePickupRequest;
use Smartdato\InPost\Requests\Pickups\ListOneTimePickupsRequest;

class PickupsResource extends BaseResource
{
    public function __construct(
        \Saloon\Http\Connector $connector,
        protected readonly string $organizationId,
    ) {
        parent::__construct($connector);
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    public function list(array $filters = []): OneTimePickupListData
    {
        $response = $this->connector->send(
            new ListOneTimePickupsRequest($this->organizationId, $filters)
        );

        return OneTimePickupListData::from($response->json());
    }

    public function create(CreateOneTimePickupData $data): OneTimePickupData
    {
        $response = $this->connector->send(
            new CreateOneTimePickupRequest($this->organizationId, $data)
        );

        return OneTimePickupData::from($response->json());
    }

    public function get(string $orderId): OneTimePickupData
    {
        $response = $this->connector->send(
            new GetOneTimePickupRequest($this->organizationId, $orderId)
        );

        return OneTimePickupData::from($response->json());
    }

    public function cancel(string $orderId): void
    {
        $this->connector->send(
            new CancelOneTimePickupRequest($this->organizationId, $orderId)
        );
    }

    public function cutoffTime(string $postalCode): CutoffTimeData
    {
        $response = $this->connector->send(new GetCutoffTimeRequest($postalCode));

        return CutoffTimeData::from($response->json());
    }
}
