<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use PHPTools\Approval\Enums\ApprovalFlowType;
use PHPTools\Approval\Enums\ApprovalStatus;
use PHPTools\Approval\Models\ApprovalTask;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;

class ApprovalTasksTable
{
    public static function table(Table $table): Table
    {
        $version = FilamentApprovalPlugin::getFilamentMajorVersion();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('laravel-filament-approval::model.id')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('laravel-filament-approval::model.approval_task.title')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('laravel-filament-approval::model.approval_task.user')),
                Tables\Columns\TextColumn::make('approvals_count')
                    ->label(__('laravel-filament-approval::model.approval_task.approvals_count'))
                    ->counts('approvals')
                    ->suffix(' ' . __('laravel-filament-approval::model.count_suffix')),
                Tables\Columns\TextColumn::make('flow_type')
                    ->label(__('laravel-filament-approval::model.approval_task.flow_type'))
                    ->formatStateUsing(
                        static fn(ApprovalFlowType $state, ApprovalTask $record) => \sprintf(
                            '%s (%d / %d)',
                            $state->getLabel(),
                            $record->approved_steps_count ?? 0,
                            $record->steps_count ?? 0
                        )
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('laravel-filament-approval::model.approval_task.status'))
                    ->formatStateUsing(static fn(ApprovalStatus $state) => $state->getLabel())
                    ->color(fn($record): string => $record->color ?? 'gray')
                    ->badge(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label(__('laravel-filament-approval::model.approval_task.approved_at')),
                Tables\Columns\TextColumn::make('rolled_back_at')
                    ->label(__('laravel-filament-approval::model.approval_task.rolled_back_at')),
            ])
            ->actions([
                ([
                    3 => \Filament\Tables\Actions\ViewAction::class,
                    4 => \Filament\Actions\ViewAction::class,
                ][$version])::make(),
            ])
            ->defaultSort('id', 'desc');
    }
}
