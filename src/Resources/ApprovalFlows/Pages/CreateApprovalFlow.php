<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Pages;

use Filament\Resources\Pages\CreateRecord;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\ApprovalFlowResource;

class CreateApprovalFlow extends CreateRecord
{
    protected static string $resource = ApprovalFlowResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
