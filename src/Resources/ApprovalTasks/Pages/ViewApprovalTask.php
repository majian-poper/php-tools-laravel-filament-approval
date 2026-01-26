<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Pages;

use Filament\Resources\Pages\ViewRecord;
use Livewire\Attributes\On;
use PHPTools\LaravelFilamentApproval\Concerns\CanHandleApprovalActions;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\ApprovalTaskResource;

class ViewApprovalTask extends ViewRecord
{
    use CanHandleApprovalActions;

    protected static string $resource = ApprovalTaskResource::class;

    #[On('refreshViewApprovalTask')]
    public function refreshViewApprovalTask(): void
    {
        // emit by StepsRelationManager or ApprovalsRelationManager
    }
}
