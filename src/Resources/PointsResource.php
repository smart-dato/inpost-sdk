<?php

namespace Smartdato\InPost\Resources;

use Saloon\Http\BaseResource;
use Smartdato\InPost\Data\Points\PointData;
use Smartdato\InPost\Data\Points\PointListData;
use Smartdato\InPost\Requests\Points\GetPointRequest;
use Smartdato\InPost\Requests\Points\ListPointsRequest;
use Smartdato\InPost\Requests\Points\SearchPointsByLocationRequest;

class PointsResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function list(array $filters = []): PointListData
    {
        $response = $this->connector->send(new ListPointsRequest($filters));

        return PointListData::from($response->json());
    }

    public function get(string $id): PointData
    {
        $response = $this->connector->send(new GetPointRequest($id));

        return PointData::from($response->json());
    }

    /**
     * @param  array<string, mixed>  $filters
     */
    public function searchByLocation(float $latitude, float $longitude, ?float $distance = null, array $filters = []): PointListData
    {
        $response = $this->connector->send(
            new SearchPointsByLocationRequest($latitude, $longitude, $distance, $filters)
        );

        return PointListData::from($response->json());
    }
}
