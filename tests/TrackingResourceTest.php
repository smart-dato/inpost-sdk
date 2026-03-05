<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Data\Tracking\TrackResponseData;
use Smartdato\InPost\Resources\TrackingResource;

function trackingResource(MockClient $mockClient): TrackingResource
{
    $auth = new InPostAuthenticator('test-id', 'test-secret', 'https://token.test', 'api:tracking:read');
    $connector = new InPostConnector($auth, 'https://api.test/tracking/v1');
    $connector->withMockClient($mockClient);

    return new TrackingResource($connector);
}

it('can track parcels', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Tracking/track-parcels')),
    ]);

    $result = trackingResource($mockClient)->track(['6340012345678901234']);

    expect($result)
        ->toBeInstanceOf(TrackResponseData::class)
        ->parcels->toHaveCount(1)
        ->and($result->parcels[0])
        ->trackingNumber->toBe('6340012345678901234')
        ->status->toBe('delivered')
        ->events->toHaveCount(2);
});
