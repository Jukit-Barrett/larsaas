<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

use Mrzkit\LaravelCodeGenerator\TemplateHandler;

interface TemplateHandlerContract
{
    /**
     * @return TemplateContract
     */
    public function getTemplateContract(): TemplateContract;

    /**
     * @param TemplateContract $templateContract
     */
    public function setTemplateContract(TemplateContract $templateContract): TemplateHandler;

    /**
     * @desc 获取写入结果
     * @return bool
     */
    public function getWriteResult(): bool;

    /**
     * @desc 获取替换结果
     * @return string
     */
    public function getReplaceResult(): string;

}
