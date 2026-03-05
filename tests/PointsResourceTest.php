<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Data\Points\PointData;
use Smartdato\InPost\Data\Points\PointListData;
use Smartdato\InPost\Resources\PointsResource;

function pointsResource(MockClient $mockClient): PointsResource
{
    $auth = new InPostAuthenticator('test-id', 'test-secret', 'https://token.test', 'api:points:read');
    $connector = new InPostConnector($auth, 'https://api.test/location/v1');
    $connector->withMockClient($mockClient);

    return new PointsResource($connector);
}

it('can list points', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/list-points')),
    ]);

    $result = pointsResource($mockClient)->list();

    expect($result)
        ->toBeInstanceOf(PointListData::class)
        ->items->toHaveCount(2)
        ->totalItems->toBe(2)
        ->and($result->items[0])
        ->toBeInstanceOf(PointData::class)
        ->id->toBe('KRA01A');
});

it('can get a point', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/get-point')),
    ]);

    $result = pointsResource($mockClient)->get('KRA01A');

    expect($result)
        ->toBeInstanceOf(PointData::class)
        ->id->toBe('KRA01A')
        ->name->toBe('Paczkomat Krakow 01A');
});

it('can search points by location', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/list-points')),
    ]);

    $result = pointsResource($mockClient)->searchByLocation(50.0647, 19.945);

    expect($result)
        ->toBeInstanceOf(PointListData::class)
        ->items->toHaveCount(2);
});
