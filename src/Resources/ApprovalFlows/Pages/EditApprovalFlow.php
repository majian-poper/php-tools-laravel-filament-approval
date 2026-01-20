<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Pages;

use Filament\Resources\Pages\EditRecord;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\ApprovalFlowResource;

class EditApprovalFlow extends EditRecord
{
    protected static string $resource = ApprovalFlowResource::class;

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }
}
