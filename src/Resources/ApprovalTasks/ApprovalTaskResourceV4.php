<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;

class ApprovalTaskResourceV4 extends Resource
{
    use Concerns\InteractsWithApprovalTasks;

    public static function infolist(Schema $schema): Schema
    {
        return Schemas\ApprovalTaskInfolist::configure($schema);
    }
}
