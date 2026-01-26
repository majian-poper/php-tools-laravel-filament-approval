<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks;

use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use PHPTools\LaravelFilamentApproval\Concerns\InteractsWithApprovalTasks;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Schemas\ApprovalTaskInfolist;

class ApprovalTaskResource extends Resource
{
    use InteractsWithApprovalTasks;

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema(ApprovalTaskInfolist::schema())
                    ->columns(2),
            ]);
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
