<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

interface RequestTemplateRenderContract
{
    public function getRuleString() : string;

    public function getMessageString() : string;
}
