<?php

namespace PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\Schemas;

use Filament\Infolists;
use PHPTools\Approval\Enums\ApprovalStatus;

class ApprovalTaskInfolist
{
    public static function schema(): array
    {
        return [
            Infolists\Components\TextEntry::make('tenant')
                ->label(__('laravel-filament-approval::model.approval_task.tenant'))
                ->inlineLabel()
                ->visible(static fn(?string $state): bool => filled($state)),
            Infolists\Components\TextEntry::make('user.name')
                ->label(__('laravel-filament-approval::model.approval_task.user'))
                ->inlineLabel(),
            Infolists\Components\TextEntry::make('title')
                ->label(__('laravel-filament-approval::model.approval_task.title'))
                ->inlineLabel(),
            Infolists\Components\TextEntry::make('status')
                ->label(__('laravel-filament-approval::model.approval_task.status'))
                ->inlineLabel()
                ->badge()
                ->color(static fn($record): string => $record->color ?? 'gray')
                ->formatStateUsing(static fn(ApprovalStatus $state) => $state->getLabel()),
            Infolists\Components\TextEntry::make('approved_at')
                ->label(__('laravel-filament-approval::model.approval_task.approved_at'))
                ->inlineLabel()
                ->badge()
                ->color('success')
                ->visible(static fn(?string $state): bool => filled($state)),
            Infolists\Components\TextEntry::make('rolled_back_at')
                ->label(__('laravel-filament-approval::model.approval_task.rolled_back_at'))
                ->inlineLabel()
                ->badge()
                ->visible(static fn($record): bool => $record->isRolledBack()),
            Infolists\Components\TextEntry::make('created_at')
                ->label(__('laravel-filament-approval::model.created_at'))
                ->inlineLabel(),
            Infolists\Components\TextEntry::make('expires_at')
                ->label(__('laravel-filament-approval::model.approval_task.expires_at'))
                ->inlineLabel()
                ->visible(static fn(?string $state): bool => filled($state)),
            Infolists\Components\TextEntry::make('ip_address')
                ->label(__('laravel-filament-approval::model.approval_task.ip_address'))
                ->inlineLabel()
                ->visible(static fn(?string $state): bool => filled($state)),
            Infolists\Components\TextEntry::make('os')
                ->label(__('laravel-filament-approval::model.approval_task.os'))
                ->inlineLabel(),
        ];
    }
}
