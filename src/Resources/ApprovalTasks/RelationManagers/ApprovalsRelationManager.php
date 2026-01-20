<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\RelationManagers;

use Filament\Infolists;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use PHPTools\Approval\Enums\ApprovableEvent;
use PHPTools\Approval\Models\Approval;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'approvals';

    protected static bool $shouldSkipAuthorization = true;

    protected static bool $isLazy = false;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('filament-approval::model.approval.label');
    }

    #[On('refreshApprovals')]
    public function refreshApprovals(): void
    {
        // emit by ViewApprovalTask
    }

    public function hydrate(): void
    {
        $this->dispatch('refreshViewApprovalTask');
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->heading(__('filament-approval::model.approval.label'))
            ->modelLabel(__('filament-approval::model.approval.label'))
            ->columns($this->columns())
            ->actions([$this->getViewAction()])
            ->defaultSort('order_number', 'asc')
            ->poll(fn(): ?string => $this->shouldPoll() ? '3s' : null);
    }

    protected function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_number')
                ->label(__('filament-approval::model.approval.order_number')),
            Tables\Columns\TextColumn::make('approvable_title')
                ->label(__('filament-approval::model.approval.approvable')),
            Tables\Columns\TextColumn::make('event')
                ->label(__('filament-approval::model.approval.event'))
                ->formatStateUsing(static fn(ApprovableEvent $state) => $state->getLabel()),
            Tables\Columns\TextColumn::make('effected_at')
                ->label(__('filament-approval::model.approval.effected_at')),
            Tables\Columns\TextColumn::make('rolled_back_at')
                ->label(__('filament-approval::model.approval.rolled_back_at')),
        ];
    }

    protected function shouldPoll(): bool
    {
        return $this->ownerRecord->isApproving() || $this->ownerRecord->isRollingBack();
    }

    protected function getViewAction(): Tables\Actions\ViewAction
    {
        return Tables\Actions\ViewAction::make('view')
            ->modalWidth(static fn(): MaxWidth => MaxWidth::ScreenExtraLarge)
            ->infolist($this->configureInfolist(...));
    }

    protected function configureInfolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist->schema(
            [
                Infolists\Components\TextEntry::make('approvable_title')
                    ->label(__('filament-approval::model.approval.approvable'))
                    ->inlineLabel(),
                Infolists\Components\TextEntry::make('event')
                    ->label(__('filament-approval::model.approval.event'))
                    ->inlineLabel()
                    ->formatStateUsing(static fn(ApprovableEvent $state) => $state->getLabel()),
                Infolists\Components\TextEntry::make('effected_at')
                    ->label(__('filament-approval::model.approval.effected_at'))
                    ->inlineLabel()
                    ->badge()
                    ->color('success')
                    ->visible(static fn(?string $state): bool => filled($state)),
                Infolists\Components\TextEntry::make('rolled_back_at')
                    ->label(__('filament-approval::model.approval.rolled_back_at'))
                    ->inlineLabel()
                    ->badge()
                    ->color('warning')
                    ->visible(static fn(?string $state): bool => filled($state)),
                Infolists\Components\Split::make(
                    [
                        Infolists\Components\KeyValueEntry::make('old_values_for_display')
                            ->label(__('filament-approval::model.approval.old_values')),
                        Infolists\Components\KeyValueEntry::make('new_values_for_display')
                            ->label(__('filament-approval::model.approval.new_values')),
                    ]
                ),
                Infolists\Components\Section::make(
                    [
                        Infolists\Components\KeyValueEntry::make('approvable.now_values_for_display'),
                    ]
                )
                    ->visible(static fn(Approval $record): bool => isset($record->approvable))
                    ->heading(__('filament-approval::model.approval.now_values'))
                    ->collapsed(),
            ]
        );
    }
}
