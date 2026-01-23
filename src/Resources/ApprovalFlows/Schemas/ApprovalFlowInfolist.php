<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas;

use Filament\Infolists;
use Filament\Schemas;
use PHPTools\Approval\Enums\ApprovalFlowType;
use PHPTools\LaravelFilamentApproval\FilamentApprovalFlowPlugin;
use PHPTools\LaravelFilamentApproval\Helper;

class ApprovalFlowInfolist
{
    /**
     * @param  Infolists\Infolist | Schemas\Schema  $infolist
     */
    public static function configure($infolist)
    {
        return $infolist->schema(static::schema());
    }

    protected static function schema(): array
    {
        return [
            static::basicSection()
                ->schema(static::basicSectionSchema())
                ->columns(2)
                ->columnSpanFull(),
            Infolists\Components\RepeatableEntry::make('steps')
                ->label(__('filament-approval::model.approval_flow_step.label'))
                ->schema(static::stepSectionSchema())
                ->columns(2)
                ->columnSpanFull(),
        ];
    }

    /**
     * @return Infolists\Components\Section | Schemas\Components\Section
     */
    protected static function basicSection()
    {
        if (Helper::getFilamentVersion() === 3) {
            return Infolists\Components\Section::make();
        }

        return Schemas\Components\Section::make();
    }

    protected static function basicSectionSchema(): array
    {
        $approvableModels = FilamentApprovalFlowPlugin::get()->getApprovableModels();

        return [
            Infolists\Components\TextEntry::make('name')
                ->label(__('filament-approval::model.approval_flow.name'))
                ->inlineLabel(),
            Infolists\Components\TextEntry::make('expiration')
                ->label(__('filament-approval::model.approval_flow.expiration_days'))
                ->inlineLabel()
                ->formatStateUsing(static fn($state) => $state ? (int) ($state / 86400) : null),
            Infolists\Components\TextEntry::make('approvable_type')
                ->label(__('filament-approval::model.approval_flow.approvable_type'))
                ->inlineLabel()
                ->formatStateUsing(static fn(string $state): string => $approvableModels[$state] ?? $state),
            Infolists\Components\TextEntry::make('flow_type')
                ->label(__('filament-approval::model.approval_flow.flow_type'))
                ->inlineLabel()
                ->formatStateUsing(static fn(ApprovalFlowType $state) => $state->getLabel()),
        ];
    }

    protected static function stepSectionSchema(): array
    {
        return [
            Infolists\Components\TextEntry::make('order_number')
                ->label(__('filament-approval::model.approval_flow_step.order_number')),
            Infolists\Components\TextEntry::make('approver.approver_title')
                ->label(__('filament-approval::model.approval_flow_step.approver')),
        ];
    }
}
