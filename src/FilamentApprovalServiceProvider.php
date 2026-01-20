<?php

namespace PHPTools\LaravelFilamentApproval;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentApprovalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-approval')
            ->hasConfigFile()
            ->hasTranslations();
    }
}
