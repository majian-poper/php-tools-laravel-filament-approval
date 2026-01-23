<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks;

use Filament\Infolists\Infolist;
use Filament\Resources\Resource;

class ApprovalTaskResourceV3 extends Resource
{
    use Concerns\InteractsWithApprovalTasks;

    public static function infolist(Infolist $infolist): Infolist
    {
        return Schemas\ApprovalTaskInfolist::configure($infolist);
    }
}
