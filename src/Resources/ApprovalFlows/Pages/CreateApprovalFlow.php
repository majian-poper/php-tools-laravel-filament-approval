<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Pages;

use Filament\Resources\Pages\CreateRecord;
use PHPTools\LaravelFilamentApproval\Concerns\HasRedirectToIndex;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\ApprovalFlowResource;

class CreateApprovalFlow extends CreateRecord
{
    use HasRedirectToIndex;

    protected static string $resource = ApprovalFlowResource::class;
}
