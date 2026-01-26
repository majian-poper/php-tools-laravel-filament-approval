<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use PHPTools\Approval\Enums\ApprovalStatus;

class StepsRelationManager extends RelationManager
{
    protected static string $relationship = 'steps';

    protected static bool $shouldSkipAuthorization = true;

    protected static bool $isLazy = false;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('laravel-filament-approval::model.approval_step.label');
    }

    #[On('refreshApprovalSteps')]
    public function refreshApprovalSteps(): void
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
            ->heading(__('laravel-filament-approval::model.approval_step.label'))
            ->modelLabel(__('laravel-filament-approval::model.approval_step.label'))
            ->columns($this->columns())
            ->defaultSort('order_number', 'asc')
            ->paginated(false)
            ->poll(fn(): ?string => $this->shouldPoll() ? '3s' : null);
    }

    protected function columns(): array
    {
        return [
            Tables\Columns\TextColumn::make('order_number')
                ->label(__('laravel-filament-approval::model.approval_step.order_number')),
            Tables\Columns\TextColumn::make('approver.approver_title')
                ->label(__('laravel-filament-approval::model.approval_step.approver')),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->label(__('laravel-filament-approval::model.approval_step.status'))
                ->formatStateUsing(static fn(ApprovalStatus $state) => $state->getLabel())
                ->color(
                    fn(ApprovalStatus $state): string => match ($state->value) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'secondary',
                    }
                ),
            Tables\Columns\TextColumn::make('user.approver_title')
                ->label(__('laravel-filament-approval::model.approval_step.user')),
            Tables\Columns\TextColumn::make('comment')
                ->label(__('laravel-filament-approval::model.approval_step.comment')),
            Tables\Columns\TextColumn::make('approved_at')
                ->label(__('laravel-filament-approval::model.approval_step.approved_at'))
                ->dateTime('Y-m-d H:i'),
        ];
    }

    protected function shouldPoll(): bool
    {
        return $this->ownerRecord->isApproving() || $this->ownerRecord->isRollingBack();
    }
}
