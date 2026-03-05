<?php

namespace Smartdato\InPost;

use Smartdato\InPost\Auth\InPostAuthenticator;
use Smartdato\InPost\Connectors\InPostConnector;
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
            scope: InPost::SCOPE_MAIN,
        ));

        $this->app->singleton(InPostAuthenticator::class.'@pickups', fn () => new InPostAuthenticator(
            clientId: (string) config('inpost-sdk.client_id'),
            clientSecret: (string) config('inpost-sdk.client_secret'),
            tokenUrl: (string) config('inpost-sdk.pickups_token_url'),
            scope: InPost::SCOPE_PICKUPS,
        ));

        $this->app->singleton(InPostConnector::class.'@shipping', fn ($app) => new InPostConnector(
            $app->make(InPostAuthenticator::class.'@main'), configKey: 'shipping',
        ));

        $this->app->singleton(InPostConnector::class.'@points', fn ($app) => new InPostConnector(
            $app->make(InPostAuthenticator::class.'@main'), configKey: 'points',
        ));

        $this->app->singleton(InPostConnector::class.'@tracking', fn ($app) => new InPostConnector(
            $app->make(InPostAuthenticator::class.'@main'), configKey: 'tracking',
        ));

        $this->app->singleton(InPostConnector::class.'@returns', fn ($app) => new InPostConnector(
            $app->make(InPostAuthenticator::class.'@main'), configKey: 'returns',
        ));

        $this->app->singleton(InPostConnector::class.'@pickups', fn ($app) => new InPostConnector(
            $app->make(InPostAuthenticator::class.'@pickups'), configKey: 'pickups',
        ));

        $this->app->singleton(InPost::class, fn ($app) => new InPost(
            shippingConnector: $app->make(InPostConnector::class.'@shipping'),
            pointsConnector: $app->make(InPostConnector::class.'@points'),
            trackingConnector: $app->make(InPostConnector::class.'@tracking'),
            returnsConnector: $app->make(InPostConnector::class.'@returns'),
            pickupsConnector: $app->make(InPostConnector::class.'@pickups'),
            organizationId: (string) config('inpost-sdk.organization_id'),
        ));
    }
}
