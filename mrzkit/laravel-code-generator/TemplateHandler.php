<?php

namespace Mrzkit\LaravelCodeGenerator;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\TemplateEngine\TemplateEngine;
use Mrzkit\TemplateEngine\TemplateFileReader;
use Mrzkit\TemplateEngine\TemplateFileWriter;

class TemplateHandler implements TemplateHandlerContract
{
    /**
     * @var TemplateContract
     */
    private $templateContract;

    /**
     * @return TemplateContract
     */
    public function getTemplateContract(): TemplateContract
    {
        return $this->templateContract;
    }

    /**
     * @param TemplateContract $templateContract
     */
    public function setTemplateContract(TemplateContract $templateContract): TemplateHandler
    {
        $this->templateContract = $templateContract;

        return $this;
    }

    /**
     * @desc 获取写入结果
     * @return bool
     */
    public function getWriteResult(): bool
    {
        $templateContract = $this->getTemplateContract();
        // 文件读取实例
        $reader = new TemplateFileReader($templateContract->getSourceTemplateFile());
        // 替换引擎实例
        $engine = new TemplateEngine($reader);
        // 初始化参数
        $engine->setContentReplacements($templateContract->getReplacementRules())->setContentReplacementsCallback($templateContract->getReplacementRuleCallbacks());
        // 执行替换
        $engine->replaceContentReplacements()->replaceContentReplacementsCallback();
        // 文件写入实例
        $writer = new TemplateFileWriter($templateContract->getSaveFilename());
        // 写入并保存文件
        $result = $writer->setContent($engine->getReplaceResult())->setForce($templateContract->getForceCover())->saveFile();

        return $result;
    }

    /**
     * @desc 获取替换结果
     * @return string
     */
    public function getReplaceResult(): string
    {
        $templateContract = $this->getTemplateContract();
        //
        $reader = new TemplateFileReader($templateContract->getSourceTemplateFile());
        //
        $engine = new TemplateEngine($reader);
        //
        $engine->setContentReplacements($templateContract->getReplacementRules())->setContentReplacementsCallback($templateContract->getReplacementRuleCallbacks());
        //
        $engine->replaceContentReplacements()->replaceContentReplacementsCallback();

        return $engine->getReplaceResult();
    }
}

