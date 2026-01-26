<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\RelationManagers;

use Filament\Infolists;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use PHPTools\Approval\Enums\ApprovableEvent;
use PHPTools\Approval\Models\Approval;
use PHPTools\LaravelFilamentApproval\Concerns\InteractsWithApprovalsRelation;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;

class ApprovalsRelationManager extends RelationManager
{
    use InteractsWithApprovalsRelation;

    protected static string $relationship = 'approvals';

    protected static bool $shouldSkipAuthorization = true;

    protected static bool $isLazy = false;

    protected function getViewAction()
    {
        $version = FilamentApprovalPlugin::getFilamentMajorVersion();

        $viewAction = [
            3 => \Filament\Tables\Actions\ViewAction::class,
            4 => \Filament\Actions\ViewAction::class,
        ][$version];

        return $viewAction::make('view')
            ->modalWidth(static fn(): MaxWidth => MaxWidth::ScreenExtraLarge)
            ->infolist($this->configureInfolist(...));
    }

    protected function configureInfolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist->schema(
            [
                Infolists\Components\TextEntry::make('approvable_title')
                    ->label(__('laravel-filament-approval::model.approval.approvable'))
                    ->inlineLabel(),
                Infolists\Components\TextEntry::make('event')
                    ->label(__('laravel-filament-approval::model.approval.event'))
                    ->inlineLabel()
                    ->formatStateUsing(static fn(ApprovableEvent $state) => $state->getLabel()),
                Infolists\Components\TextEntry::make('effected_at')
                    ->label(__('laravel-filament-approval::model.approval.effected_at'))
                    ->inlineLabel()
                    ->badge()
                    ->color('success')
                    ->visible(static fn(?string $state): bool => filled($state)),
                Infolists\Components\TextEntry::make('rolled_back_at')
                    ->label(__('laravel-filament-approval::model.approval.rolled_back_at'))
                    ->inlineLabel()
                    ->badge()
                    ->color('warning')
                    ->visible(static fn(?string $state): bool => filled($state)),
                Infolists\Components\Split::make(
                    [
                        Infolists\Components\KeyValueEntry::make('old_values_for_display')
                            ->label(__('laravel-filament-approval::model.approval.old_values')),
                        Infolists\Components\KeyValueEntry::make('new_values_for_display')
                            ->label(__('laravel-filament-approval::model.approval.new_values')),
                    ]
                ),
                Infolists\Components\Section::make(
                    [
                        Infolists\Components\KeyValueEntry::make('approvable.now_values_for_display'),
                    ]
                )
                    ->visible(static fn(Approval $record): bool => isset($record->approvable))
                    ->heading(__('laravel-filament-approval::model.approval.now_values'))
                    ->collapsed(),
            ]
        );
    }
}
