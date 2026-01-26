<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Schemas;

use Filament\Forms;
use PHPTools\Approval\Enums\ApprovalFlowType;

class ApprovalFlowForm
{
    public static function schema(): array
    {
        $approverModels = config('filament-approval.approver_models');
        $expirationDays = config('filament-approval.expiration_days');
        $expirationOptions = array_combine($expirationDays, $expirationDays);

        return [
            Forms\Components\TextInput::make('name')
                ->label(__('laravel-filament-approval::model.approval_flow.name'))
                ->autofocus()
                ->required()
                ->columnSpanFull(),
            Forms\Components\Select::make('approvable_type')
                ->label(__('laravel-filament-approval::model.approval_flow.approvable_type'))
                ->options(config('filament-approval.approvable_models'))
                ->required()
                ->columnSpanFull(),
            Forms\Components\Select::make('flow_type')
                ->label(__('laravel-filament-approval::model.approval_flow.flow_type'))
                ->options(ApprovalFlowType::options())
                ->required(),
            Forms\Components\Select::make('expiration')
                ->label(__('laravel-filament-approval::model.approval_flow.expiration_days'))
                ->options($expirationOptions)
                ->formatStateUsing(static fn ($state) => $state ? (int) ($state / 86400) : null)
                ->dehydrateStateUsing(static fn ($state) => $state ? (int) $state * 86400 : null)
                ->required(),
            Forms\Components\Repeater::make('steps')
                ->label(__('laravel-filament-approval::model.approval_flow_step.label'))
                ->relationship('steps')
                ->orderColumn('order_number')
                ->schema([
                    Forms\Components\MorphToSelect::make('approver')
                        ->label(__('laravel-filament-approval::model.approval_flow_step.approver'))
                        ->types(
                            collect($approverModels)->map(
                                static fn ($label, $class) => Forms\Components\MorphToSelect\Type::make($class)
                                    ->label($label)
                                    ->titleAttribute('name')
                            )->all()
                        )
                        ->required(),
                ])
                ->columnSpanFull(),
        ];
    }
}
