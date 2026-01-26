<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas;

use Filament\Infolists;
use PHPTools\Approval\Enums\ApprovalFlowType;

class ApprovalFlowInfolist
{
    public static function schema(): array
    {
        $approvableModels = config('filament-approval.approvable_models');

        return [
            Infolists\Components\Section::make(__('laravel-filament-approval::model.basic_information'))
                ->schema([
                    Infolists\Components\TextEntry::make('name')
                        ->label(__('laravel-filament-approval::model.approval_flow.name'))
                        ->inlineLabel(),
                    Infolists\Components\TextEntry::make('approvable_type')
                        ->label(__('laravel-filament-approval::model.approval_flow.approvable_type'))
                        ->inlineLabel()
                        ->formatStateUsing(static fn (string $state): string => $approvableModels[$state] ?? $state),
                    Infolists\Components\TextEntry::make('flow_type')
                        ->label(__('laravel-filament-approval::model.approval_flow.flow_type'))
                        ->inlineLabel()
                        ->formatStateUsing(static fn (ApprovalFlowType $state) => $state->getLabel()),
                    Infolists\Components\TextEntry::make('expiration')
                        ->label(__('laravel-filament-approval::model.approval_flow.expiration_days'))
                        ->inlineLabel()
                        ->formatStateUsing(static fn ($state) => $state ? (int) ($state / 86400) : null),
                ]),
            Infolists\Components\RepeatableEntry::make('steps')
                ->label(__('laravel-filament-approval::model.approval_flow_step.label'))
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('order_number')
                        ->label(__('laravel-filament-approval::model.approval_flow_step.order_number')),
                    Infolists\Components\TextEntry::make('approver.approver_title')
                        ->label(__('laravel-filament-approval::model.approval_flow_step.approver')),
                ])
                ->columnSpanFull(),
        ];
    }
}
