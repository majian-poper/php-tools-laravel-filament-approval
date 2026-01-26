<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks;

use Filament\Resources\Resource;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use PHPTools\LaravelFilamentApproval\Concerns\InteractsWithApprovalTasks;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Schemas\ApprovalTaskInfolist;

class ApprovalTaskResourceV4 extends Resource
{
    use InteractsWithApprovalTasks;

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make()
                    ->schema(ApprovalTaskInfolist::schema())
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApprovalsRelationManagerV4::class,
            RelationManagers\StepsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalTasksV4::route('/'),
            'view' => Pages\ViewApprovalTaskV4::route('/{record}'),
        ];
    }
}
