<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;
use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
use Smartdato\InPost\Data\Tracking\EventLocationData;
use Smartdato\InPost\Data\Tracking\TrackingEventData;
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
        ->parcels->toHaveCount(1);

    $parcel = $result->parcels[0];

    expect($parcel)
        ->trackingNumber->toBe('6340012345678901234')
        ->status->toBe('delivered')
        ->events->toHaveCount(2);

    $event = $parcel->events[0];

    expect($event)
        ->toBeInstanceOf(TrackingEventData::class)
        ->eventCode->toBe('LMD.9001')
        ->eventTimestamp->toBe('2026-03-05T14:30:00.031+00:00')
        ->and($event->location)
        ->toBeInstanceOf(EventLocationData::class)
        ->name->toBe('ITCES432MMM')
        ->city->toBe('Warsaw');
});

it('can track parcels returning the raw response', function () {
    $mockClient = new MockClient([
        MockResponse::make(fixtureJson('Tracking/track-parcels')),
    ]);

    $response = trackingResource($mockClient)->trackRaw(['6340012345678901234']);

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->json('parcels.0.events.0.eventCode'))->toBe('LMD.9001');
});
