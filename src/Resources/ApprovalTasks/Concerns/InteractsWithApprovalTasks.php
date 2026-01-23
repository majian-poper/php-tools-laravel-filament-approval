<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Concerns;

use Filament\Panel;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use PHPTools\LaravelFilamentApproval\FilamentApprovalTaskPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Pages;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\RelationManagers;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Tables;

trait InteractsWithApprovalTasks
{
    public static function getSlug(?Panel $panel = null): string
    {
        return FilamentApprovalTaskPlugin::getRouteSlug();
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentApprovalTaskPlugin::get()->getNavigationSort();
    }

    public static function getNavigationIcon(): ?string
    {
        return FilamentApprovalTaskPlugin::get()->getNavigationIcon();
    }

    public static function getModel(): string
    {
        return config('approval.implementations.approval_task');
    }

    public static function getModelLabel(): string
    {
        return __('filament-approval::model.approval_task.label');
    }

    public static function getEloquentQuery(): Builder
    {
        $plugin = FilamentApprovalTaskPlugin::get();

        $builder = $plugin->modifyQuery(parent::getEloquentQuery());

        if ($plugin->isApproverMode()) {
            $builder->when(
                empty($currentApprovers = $plugin->getCurrentApprovers()),
                static fn(Builder $query): Builder => $query->whereRaw('1 = 0'),
                static fn(Builder $query): Builder => $query->whereApprovers(...$currentApprovers)
            );
        } else {
            $builder->whereMorphedTo('user', $plugin->getCurrentUser());
        }

        return $builder->with(['steps'])->whereHas('approvals');
    }

    public static function table(Table $table): Table
    {
        return Tables\ApprovalTasksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalTasks::route('/'),
            'view' => Pages\ViewApprovalTask::route('/{record}/view'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApprovalsRelationManager::class,
            RelationManagers\StepsRelationManager::class,
        ];
    }
}
