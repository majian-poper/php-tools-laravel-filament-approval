<?php

namespace PHPTools\LaravelFilamentApproval;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Contracts\Auth\Authenticatable;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalFlows\ApprovalFlowResource;
use PHPTools\LaravelFilamentApproval\Resources\ApprovalTasks\ApprovalTaskResource;

class FilamentApprovalPlugin implements Plugin
{
    protected bool $hasApprovalFlows = true;

    protected bool $hasApprovalTasks = true;

    protected bool $enableApproval = true;

    protected ?\Closure $resolveApproversUsing = null;

    protected array | \Closure $tabs = [];

    public function getId(): string
    {
        return 'filament-approval';
    }

    public static function make(): static
    {
        return new static;
    }

    public function register(Panel $panel): void
    {
        $resources = [];

        if ($this->hasApprovalFlows) {
            $resources[] = ApprovalFlowResource::class;
        }

        if ($this->hasApprovalTasks) {
            $resources[] = ApprovalTaskResource::class;
        }

        $panel->resources($resources);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function withoutApprovalFlows(): static
    {
        $this->hasApprovalFlows = false;

        return $this;
    }

    public function approvable(bool $enable = true): static
    {
        $this->enableApproval = $enable;

        return $this;
    }

    public function forbidApproval(): bool
    {
        return ! $this->enableApproval;
    }

    public function resolveApproversUsing(\Closure $callback): static
    {
        $this->resolveApproversUsing = $callback;

        return $this;
    }

    public function getApprovers(Authenticatable $user): array
    {
        if ($this->resolveApproversUsing) {
            return call_user_func($this->resolveApproversUsing, $user);
        }

        return [$user];
    }

    public function hasTabs(array | \Closure $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function getTabs($page): array
    {
        if ($this->tabs instanceof \Closure) {
            return call_user_func($this->tabs, $page);
        }

        return $this->tabs;
    }
}
