<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use PHPTools\Approval\Enums\ApprovalFlowType;
use PHPTools\LaravelFilamentApproval\FilamentApprovalPlugin;

class ApprovalFlowsTable
{
    public static function table(Table $table): Table
    {
        $version = FilamentApprovalPlugin::getFilamentMajorVersion();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('laravel-filament-approval::model.id')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('laravel-filament-approval::model.approval_flow.name')),
                Tables\Columns\SelectColumn::make('approvable_type')
                    ->label(__('laravel-filament-approval::model.approval_flow.approvable_type'))
                    ->options(config('filament-approval.approvable_models'))
                    ->disabled(),
                Tables\Columns\SelectColumn::make('flow_type')
                    ->label(__('laravel-filament-approval::model.approval_flow.flow_type'))
                    ->options(ApprovalFlowType::options())
                    ->disabled(),
                Tables\Columns\TextColumn::make('expiration')
                    ->label(__('laravel-filament-approval::model.approval_flow.expiration_days'))
                    ->formatStateUsing(static fn ($state) => $state ? (int) ($state / 86400) : null),
            ])
            ->actions([
                ([
                    3 => \Filament\Tables\Actions\ViewAction::class,
                    4 => \Filament\Actions\ViewAction::class,
                ][$version])::make(),
                ([
                    3 => \Filament\Tables\Actions\EditAction::class,
                    4 => \Filament\Actions\EditAction::class,
                ][$version])::make(),
                ([
                    3 => \Filament\Tables\Actions\DeleteAction::class,
                    4 => \Filament\Actions\DeleteAction::class,
                ][$version])::make(),
            ])
            ->bulkActions([
                ([
                    3 => \Filament\Tables\Actions\DeleteBulkAction::class,
                    4 => \Filament\Actions\DeleteBulkAction::class,
                ][$version])::make(),
            ])
            ->defaultSort('id', 'desc');
    }
}
