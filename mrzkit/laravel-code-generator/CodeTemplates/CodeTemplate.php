<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

interface CodeTemplate
{
    /**
     * @desc 获取代码字符串
     * @return string
     */
    public function getCodeString(): string;
}
