<?php

namespace PHPTools\LaravelFilamentApproval;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentApprovalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-filament-approval')
            ->hasConfigFile()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-filament-approval');
    }
}
