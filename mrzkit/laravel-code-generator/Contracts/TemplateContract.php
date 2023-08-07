<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

interface TemplateContract
{
    /**
     * @desc 强制覆盖
     * @return bool
     */
    public function getForceCover(): bool;

    /**
     * @desc 保存目录
     * @return string
     */
    public function getSaveDirectory(): string;

    /**
     * @desc 保存文件
     * @return string
     */
    public function getSaveFilename(): string;

    /**
     * @desc 源模板文件
     * @return string
     */
    public function getSourceTemplateFile(): string;

    /**
     * @desc 替换结果
     * @return string[]
     */
    public function getReplacementRules(): array;

    /**
     * @desc 替换结果回调
     * @return string[]
     */
    public function getReplacementRuleCallbacks(): array;
}
