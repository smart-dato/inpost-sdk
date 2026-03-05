<?php

namespace Smartdato\InPost;

use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\PickupsConnector;
use Smartdato\InPost\Connectors\PointsConnector;
use Smartdato\InPost\Connectors\ReturnsConnector;
use Smartdato\InPost\Connectors\ShippingConnector;
use Smartdato\InPost\Connectors\TrackingConnector;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InPostServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('inpost-sdk')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(InPostAuthenticator::class.'@main', fn () => new InPostAuthenticator(
            clientId: (string) config('inpost-sdk.client_id'),
            clientSecret: (string) config('inpost-sdk.client_secret'),
            tokenUrl: (string) config('inpost-sdk.token_url'),
            scope: 'api:shipments:read api:shipments:write api:points:read api:tracking:read api:returns:read api:returns:write',
        ));

        $this->app->singleton(InPostAuthenticator::class.'@pickups', fn () => new InPostAuthenticator(
            clientId: (string) config('inpost-sdk.client_id'),
            clientSecret: (string) config('inpost-sdk.client_secret'),
            tokenUrl: (string) config('inpost-sdk.pickups_token_url'),
            scope: 'api:one-time-pickups:read api:one-time-pickups:write',
        ));

        $this->app->singleton(ShippingConnector::class, fn ($app) => new ShippingConnector(
            $app->make(InPostAuthenticator::class.'@main'),
        ));

        $this->app->singleton(PointsConnector::class, fn ($app) => new PointsConnector(
            $app->make(InPostAuthenticator::class.'@main'),
        ));

        $this->app->singleton(TrackingConnector::class, fn ($app) => new TrackingConnector(
            $app->make(InPostAuthenticator::class.'@main'),
        ));

        $this->app->singleton(ReturnsConnector::class, fn ($app) => new ReturnsConnector(
            $app->make(InPostAuthenticator::class.'@main'),
        ));

        $this->app->singleton(PickupsConnector::class, fn ($app) => new PickupsConnector(
            $app->make(InPostAuthenticator::class.'@pickups'),
        ));

        $this->app->singleton(InPost::class, fn ($app) => new InPost(
            shippingConnector: $app->make(ShippingConnector::class),
            pointsConnector: $app->make(PointsConnector::class),
            trackingConnector: $app->make(TrackingConnector::class),
            returnsConnector: $app->make(ReturnsConnector::class),
            pickupsConnector: $app->make(PickupsConnector::class),
            organizationId: (string) config('inpost-sdk.organization_id'),
        ));
    }
}
