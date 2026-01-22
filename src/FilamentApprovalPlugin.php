<?php

namespace PHPTools\LaravelFilamentApproval;

use Composer\InstalledVersions;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Contracts\Auth\Authenticatable;

class FilamentApprovalPlugin implements Plugin
{
    protected bool $hasApprovalFlows = true;

    protected bool $hasApprovalTasks = true;

    protected bool $enableApproval = true;

    protected ?\Closure $resolveApproversUsing = null;

    protected array | \Closure $tabs = [];

    protected int $flowNavigationSort = 0;

    protected int $taskNavigationSort = 1;

    public function getId(): string
    {
        return 'laravel-filament-approval';
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public static function make(): static
    {
        return new static;
    }

    public static function getFilamentMajorVersion(): int
    {
        try {
            $version = InstalledVersions::getPrettyVersion('filament/filament');

            return (int) ltrim($version, 'v');
        } catch (\Exception $e) {
            return 3;
        }
    }

    public function register(Panel $panel): void
    {
        $resources = [];

        if ($this->hasApprovalFlows) {
            $resources[] = [
                3 => Resources\ApprovalFlows\ApprovalFlowResource::class,
                4 => Resources\ApprovalFlows\ApprovalFlowResourceV4::class,
            ][static::getFilamentMajorVersion()];
        }

        if ($this->hasApprovalTasks) {
            $resources[] = [
                3 => Resources\ApprovalTasks\ApprovalTaskResource::class,
                4 => Resources\ApprovalTasks\ApprovalTaskResourceV4::class,
            ][static::getFilamentMajorVersion()];
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

    public function navigationSort(?int $flowNavigationSort = null, ?int $taskNavigationSort = null): static
    {
        if ($flowNavigationSort) {
            $this->flowNavigationSort = $flowNavigationSort;
        }

        if ($taskNavigationSort) {
            $this->taskNavigationSort = $taskNavigationSort;
        }

        return $this;
    }

    public function getFlowNavigationSort()
    {
        return $this->flowNavigationSort;
    }

    public function getTaskNavigationSort()
    {
        return $this->taskNavigationSort;
    }
}
