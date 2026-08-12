<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Data\Points\OpeningPeriodData;
use Smartdato\InPost\Data\Points\PointData;
use Smartdato\InPost\Data\Points\PointListData;
use Smartdato\InPost\Enums\PointType;
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
        ->count->toBe(115792)
        ->page->toBe(1)
        ->perPage->toBe(2)
        ->totalPages->toBe(57896)
        ->and($result->items[0])
        ->toBeInstanceOf(PointData::class)
        ->id->toBe('PL_ADA01M');
});

it('maps the point payload the API really returns', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/list-points')),
    ]);

    $point = pointsResource($mockClient)->list()->items[0];

    expect($point)
        ->id->toBe('PL_ADA01M')
        ->displayName->toBe('InPost Paczkomat ADA01M')
        ->type->toBe(PointType::APM)
        ->country->toBe('PL')
        ->locationType->toBe('OUTDOOR')
        ->location247->toBeTrue()
        ->imageUrl->toBe('https://static.easypack24.net/points/pl/images/ADA01M.jpg')
        ->capabilities->toBe(['PARCEL_COLLECT', 'PARCEL_SEND'])
        ->and($point->address)
        ->country->toBe('PL')
        ->administrativeArea->toBe('lubelskie')
        ->city->toBe('Adamów')
        ->street->toBe('Kościuszki')
        ->buildingNumber->toBe('27')
        ->postalCode->toBe('21-412')
        ->and($point->coordinates)
        ->latitude->toBe(51.73834)
        ->longitude->toBe(22.26405)
        ->and($point->description)
        ->content->toBe('Przy sklepie Lewiatan')
        ->and($point->operatingHours->customer)->toBeNull();
});

it('maps the nested operating hours', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/list-points')),
    ]);

    $point = pointsResource($mockClient)->list()->items[1];

    expect($point)
        ->type->toBe(PointType::PUDO)
        ->location247->toBeFalse()
        ->and($point->operatingHours->customer->monday)
        ->toHaveCount(1)
        ->and($point->operatingHours->customer->monday[0])
        ->toBeInstanceOf(OpeningPeriodData::class)
        ->start->toBe('06:00')
        ->end->toBe('22:00');
});

it('can get a point', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Points/get-point')),
    ]);

    $result = pointsResource($mockClient)->get('PL_ADA01M');

    expect($result)
        ->toBeInstanceOf(PointData::class)
        ->id->toBe('PL_ADA01M')
        ->displayName->toBe('InPost Paczkomat ADA01M');
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
