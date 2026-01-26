<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Tables\ApprovalTasksTable;

trait InteractsWithApprovalTasks
{
    public static function getNavigationIcon(): ?string
    {
        return config('filament-approval.navigation_icon.approval_task');
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentApprovalPlugin::get()->getTaskNavigationSort();
    }

    public static function getSlug(?\Filament\Panel $panel = null): string
    {
        return 'approval-tasks';
    }

    public static function getModel(): string
    {
        return config('approval.implementations.approval_task');
    }

    public static function getModelLabel(): string
    {
        return __('laravel-filament-approval::model.approval_task.label');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        $plugin = FilamentApprovalPlugin::get();

        if ($plugin->forbidApproval()) {
            return parent::getEloquentQuery()->whereMorphedTo('user', $user)->with(['steps']);
        }

        $approvers = $plugin->getApprovers($user);

        return parent::getEloquentQuery()
            ->whereHas('approvals')
            ->whereApprovers(...$approvers)
            ->with(['steps']);
    }

    public static function table(Table $table): Table
    {
        return ApprovalTasksTable::table($table);
    }
}
