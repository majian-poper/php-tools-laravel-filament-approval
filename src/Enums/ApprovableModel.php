<?php

namespace PHPTools\LaravelFilamentApproval\Enums;

class ApprovableModel
{
    public static function options(): array
    {
        return collect(config('filament-approval.approvable_models', []))
            ->map(static fn ($label) => __($label))
            ->toArray();
    }
}
