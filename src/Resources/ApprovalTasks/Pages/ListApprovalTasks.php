<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Pages;

use Filament\Resources\Pages\ListRecords;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\ApprovalTaskResource;

class ListApprovalTasks extends ListRecords
{
    protected static string $resource = ApprovalTaskResource::class;

    public function getTabs(): array
    {
        $plugin = FilamentApprovalPlugin::get();

        return $plugin->getTabs($this);
    }
}
