<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait InteractsWithPlugin
{
    use EvaluatesClosures;

    protected int $navigationSort = 0;

    protected string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected array | \Closure $tabs = [];

    protected array | \Closure $filters = [];

    protected ?\Closure $modifyQueryUsing = null;

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(static::getPluginId());
    }

    abstract public static function getPluginId(): string;

    abstract public static function getResourceClass(): string;

    abstract public static function getRouteSlug(): string;

    public function getId(): string
    {
        return static::getPluginId();
    }

    public function register(Panel $panel): void
    {
        $panel->resources([static::getResourceClass()]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function navigationSort(int $sort): static
    {
        $this->navigationSort = $sort;

        return $this;
    }

    public function getNavigationSort(): int
    {
        return $this->navigationSort;
    }

    public function navigationIcon(string $icon): static
    {
        $this->navigationIcon = $icon;

        return $this;
    }

    public function getNavigationIcon(): string
    {
        return $this->navigationIcon;
    }

    public function tabs(array | \Closure $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function getTabs(): array
    {
        return $this->tabs = Arr::from($this->evaluate($this->tabs));
    }

    public function filters(array | \Closure $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters = Arr::from($this->evaluate($this->filters));
    }

    public function modifyQueryUsing(?\Closure $callback): static
    {
        $this->modifyQueryUsing = $callback;

        return $this;
    }

    public function modifyQuery(Builder $query): Builder
    {
        return $this->evaluate($this->modifyQueryUsing, ['query' => $query]) ?? $query;
    }
}
