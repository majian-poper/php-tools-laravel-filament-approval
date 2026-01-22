<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use PHPTools\LaravelFilamentApproval\Concerns\InteractsWithApprovalFlows;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowForm;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas\ApprovalFlowInfolistV4;

class ApprovalFlowResourceV4 extends Resource
{
    use InteractsWithApprovalFlows;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema(ApprovalFlowForm::schema());
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema(ApprovalFlowInfolistV4::schema());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApprovalFlowsV4::route('/'),
            'create' => Pages\CreateApprovalFlowV4::route('/create'),
            'edit' => Pages\EditApprovalFlowV4::route('/{record}/edit'),
        ];
    }
}
