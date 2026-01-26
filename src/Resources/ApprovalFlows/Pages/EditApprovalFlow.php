<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Pages;

use Filament\Resources\Pages\EditRecord;
use PHPTools\LaravelFilamentApproval\Concerns\HasRedirectToIndex;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\ApprovalFlowResource;

class EditApprovalFlow extends EditRecord
{
    use HasRedirectToIndex;

    protected static string $resource = ApprovalFlowResource::class;
}
