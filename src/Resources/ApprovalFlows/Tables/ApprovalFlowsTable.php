<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use PHPTools\Approval\Enums\ApprovalFlowType;
use PHPTools\LaravelFilamentApproval\Enums\ApprovableModel;

class ApprovalFlowsTable
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('filament-approval::model.id')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-approval::model.approval_flow.name')),
                Tables\Columns\SelectColumn::make('approvable_type')
                    ->label(__('filament-approval::model.approval_flow.approvable_type'))
                    ->options(ApprovableModel::options())
                    ->disabled(),
                Tables\Columns\SelectColumn::make('flow_type')
                    ->label(__('filament-approval::model.approval_flow.flow_type'))
                    ->options(ApprovalFlowType::options())
                    ->disabled(),
                Tables\Columns\TextColumn::make('expiration')
                    ->label(__('filament-approval::model.approval_flow.expiration_days'))
                    ->formatStateUsing(static fn ($state) => $state ? (int) ($state / 86400) : null),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }
}
