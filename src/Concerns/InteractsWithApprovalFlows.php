<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

use Filament\Tables\Table;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Tables\ApprovalFlowsTable;

trait InteractsWithApprovalFlows
{
    public static function getNavigationIcon(): ?string
    {
        return config('filament-approval.navigation_icon.approval_flow');
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentApprovalPlugin::get()->getFlowNavigationSort();
    }

    public static function getSlug(?\Filament\Panel $panel = null): string
    {
        return 'approval-flows';
    }

    public static function getModel(): string
    {
        return config('approval.implementations.approval_flow');
    }

    public static function getModelLabel(): string
    {
        return __('laravel-filament-approval::model.approval_flow.label');
    }

    public static function table(Table $table): Table
    {
        return ApprovalFlowsTable::table($table);
    }
}
