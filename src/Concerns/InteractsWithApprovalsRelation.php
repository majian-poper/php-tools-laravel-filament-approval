<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use PHPTools\Approval\Enums\ApprovableEvent;

trait InteractsWithApprovalsRelation
{
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('laravel-filament-approval::model.approval.label');
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
            ->heading(__('laravel-filament-approval::model.approval.label'))
            ->modelLabel(__('laravel-filament-approval::model.approval.label'))
            ->columns($this->columns())
            ->actions([$this->getViewAction()])
            ->defaultSort('order_number', 'asc')
            ->poll(fn(): ?string => $this->shouldPoll() ? '3s' : null);
    }

    protected function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_number')
                ->label(__('laravel-filament-approval::model.approval.order_number')),
            Tables\Columns\TextColumn::make('approvable_title')
                ->label(__('laravel-filament-approval::model.approval.approvable')),
            Tables\Columns\TextColumn::make('event')
                ->label(__('laravel-filament-approval::model.approval.event'))
                ->formatStateUsing(static fn(ApprovableEvent $state) => $state->getLabel()),
            Tables\Columns\TextColumn::make('effected_at')
                ->label(__('laravel-filament-approval::model.approval.effected_at')),
            Tables\Columns\TextColumn::make('rolled_back_at')
                ->label(__('laravel-filament-approval::model.approval.rolled_back_at')),
        ];
    }

    protected function shouldPoll(): bool
    {
        return $this->ownerRecord->isApproving() || $this->ownerRecord->isRollingBack();
    }
}
