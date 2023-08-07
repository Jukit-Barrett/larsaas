<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

interface DataTypeMatchContract
{
    public function matchInt() : array;

    public function matchString() : array;

    public function matchFloat() : array;

    public function matchDate() : array;
}
