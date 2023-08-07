<?php

namespace Mrzkit\LaravelEloquentEnhance;

use Closure;
use Mrzkit\LaravelEloquentEnhance\Contracts\RetrieveQueryContract;

abstract class RetrieveQuery implements RetrieveQueryContract
{
    public function columns(): array
    {
        return ['*'];
    }

    public function sort(): string
    {
        return "";
    }

    public function paging(): array
    {
        return [];
    }

    public function relations(): array
    {
        return [];
    }

    public function before(): ?Closure
    {
        return null;
    }

    public function after(): ?Closure
    {
        return null;
    }

}
