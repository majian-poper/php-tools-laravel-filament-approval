<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

use Filament\Actions;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use PHPTools\Approval\Models\ApprovalTask;

trait CanHandleApprovalActions
{
    protected function getHeaderActions(): array
    {
        /** @var ApprovalTask $record */
        $record = $this->getRecord();

        $user = Auth::user();

        if ($record->canBeChangedStatusBy($user)) {
            return [
                $this->getApproveAction(),
                $this->getRejectAction(),
            ];
        }

        if ($record->canBeRolledBackBy($user)) {
            return [
                $this->getRollbackAction(),
            ];
        }

        return [];
    }

    protected function getApproveAction(): Actions\Action
    {
        return $this->getApprovalTaskAction('approve')
            ->form($this->commentFormSchema('approve'))
            ->defaultColor('success')
            ->icon('heroicon-m-check')
            ->action(
                function (Actions\Action $action, Forms\Form $form, ApprovalTask $record): void {
                    $state = $form->getState();

                    try {
                        $record->approve($state['comment'] ?? '');
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle($e->getMessage());

                        $action->failure();

                        return;
                    }

                    $action->success();
                }
            );
    }

    protected function getRejectAction(): Actions\Action
    {
        return $this->getApprovalTaskAction('reject')
            ->form($this->commentFormSchema('reject'))
            ->defaultColor('danger')
            ->icon('heroicon-m-x-mark')
            ->action(
                function (Actions\Action $action, Forms\Form $form, ApprovalTask $record): void {
                    $state = $form->getState();

                    try {
                        $record->reject($state['comment'] ?? '');
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle($e->getMessage());

                        $action->failure();

                        return;
                    }

                    $action->success();
                }
            );
    }

    protected function getRollbackAction(): Actions\Action
    {
        return $this->getApprovalTaskAction('rollback')
            ->defaultColor('warning')
            ->icon('heroicon-m-arrow-uturn-left')
            ->action(
                function (Actions\Action $action, ApprovalTask $record): void {
                    try {
                        $record->rollBack();
                    } catch (\Exception $e) {
                        $action->failureNotificationTitle($e->getMessage());

                        $action->failure();

                        return;
                    }

                    $action->success();
                }
            );
    }

    protected function getApprovalTaskAction(string $action): Actions\Action
    {
        return Actions\Action::make($action)
            ->requiresConfirmation()
            ->label(__("laravel-filament-approval::approvals.actions.{$action}.single.label"))
            ->modalHeading(fn(): string => __("laravel-filament-approval::approvals.actions.{$action}.single.modal.heading", ['label' => $this->getRecordTitle()]))
            ->modalSubmitActionLabel(__("laravel-filament-approval::approvals.actions.{$action}.single.modal.actions.{$action}.label"))
            ->successNotificationTitle(__("laravel-filament-approval::approvals.actions.{$action}.single.notifications.success.title"))
            ->after(
                function (): void {
                    $this->dispatch('refreshApprovalSteps');
                    $this->dispatch('refreshApprovals');
                }
            );
    }

    protected function commentFormSchema(string $action): array
    {
        return [
            Forms\Components\TextInput::make('comment')
                ->label(__("laravel-filament-approval::approvals.actions.{$action}.single.modal.form.comment"))
                ->maxLength(255),
        ];
    }
}
