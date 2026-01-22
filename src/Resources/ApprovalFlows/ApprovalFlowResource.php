<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use PHPTools\LaravelFilamentApproval\Concerns\InteractsWithApprovalFlows;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowForm;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowInfolist;

class ApprovalFlowResource extends Resource
{
    use InteractsWithApprovalFlows;

    public static function form(Form $form): Form
    {
        return $form->schema(ApprovalFlowForm::schema());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(ApprovalFlowInfolist::schema());
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
