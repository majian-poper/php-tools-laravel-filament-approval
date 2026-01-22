<?php

namespace PHPTools\LaravelFilamentApproval\Concerns;

trait HasRedirectToIndex
{
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
