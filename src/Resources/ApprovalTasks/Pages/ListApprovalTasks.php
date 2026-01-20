<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Pages;

use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\ApprovalTaskResource;

class ListApprovalTasks extends ListRecords
{
    protected static string $resource = ApprovalTaskResource::class;

    public function getTabs(): array
    {
        /** @var FilamentApprovalPlugin $plugin */
        $plugin = Filament::getCurrentPanel()->getPlugin('filament-approval');

        return $plugin->getTabs($this);
    }
}
