<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks;

use Filament\Facades\Filament;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Schemas\ApprovalTaskInfolist;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Tables\ApprovalTasksTable;

class ApprovalTaskResource extends Resource
{
    public static function getNavigationIcon(): ?string
    {
        return config('filament-approval.navigation_icon.approval_task', 'heroicon-o-rectangle-stack');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-approval.navigation_sort.approval_task');
    }

    public static function getSlug(): string
    {
        return 'approval-tasks';
    }

    public static function getModel(): string
    {
        return config('filament-approval.models.approval_task', \PHPTools\Approval\Models\ApprovalTask::class);
    }

    public static function getModelLabel(): string
    {
        return __('filament-approval::model.approval_task.label');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        /** @var FilamentApprovalPlugin $plugin */
        $plugin = Filament::getCurrentPanel()->getPlugin('filament-approval');

        if ($plugin->forbidApproval()) {
            return parent::getEloquentQuery()->whereMorphedTo('user', $user)->with(['steps']);
        }

        $approvers = $plugin->getApprovers($user);

        return parent::getEloquentQuery()
            ->whereHas('approvals')
            ->whereApprovers(...$approvers)
            ->with(['steps']);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema(ApprovalTaskInfolist::schema())
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ApprovalTasksTable::table($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApprovalsRelationManager::class,
            RelationManagers\StepsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalTasks::route('/'),
            'view' => Pages\ViewApprovalTask::route('/{record}'),
        ];
    }
}
