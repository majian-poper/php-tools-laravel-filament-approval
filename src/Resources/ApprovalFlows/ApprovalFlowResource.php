<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use PHPTools\Approval\Models\ApprovalFlow;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowForm;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowInfolist;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Tables\ApprovalFlowsTable;

class ApprovalFlowResource extends Resource
{
    public static function getNavigationIcon(): ?string
    {
        return config('filament-approval.navigation_icon.approval_flow', 'heroicon-o-rectangle-stack');
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-approval.navigation_sort.approval_flow');
    }

    public static function getSlug(): string
    {
        return 'approval-flows';
    }

    public static function getModel(): string
    {
        return config('filament-approval.models.approval_flow', ApprovalFlow::class);
    }

    public static function getModelLabel(): string
    {
        return __('filament-approval::model.approval_flow.label');
    }

    public static function form(Form $form): Form
    {
        return $form->schema(ApprovalFlowForm::schema());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(ApprovalFlowInfolist::schema());
    }

    public static function table(Table $table): Table
    {
        return ApprovalFlowsTable::table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalFlows::route('/'),
            'create' => Pages\CreateApprovalFlow::route('/create'),
            'edit' => Pages\EditApprovalFlow::route('/{record}/edit'),
        ];
    }
}
