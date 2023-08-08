<?php

namespace Mrzkit\LaravelCodeGenerator;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\TemplateEngine\TemplateEngine;
use Mrzkit\TemplateEngine\TemplateFileReader;
use Mrzkit\TemplateEngine\TemplateFileWriter;

class TemplateGenerator implements TemplateGeneration
{
    /**
     * @var bool 是否强制覆盖: true=覆盖,false=不覆盖
     */
    private $forceCover;

    /**
     * @var string 保存目录
     */
    private $saveDirectory;

    /**
     * @var string 保存文件名称
     */
    private $saveFilename;

    /**
     * @var string 模板文件
     */
    private $sourceTemplateFile;

    /**
     * @var string[] 替换规则
     */
    private $replacementRules;

    /**
     * @var array 替换规则
     */
    private $replacementRuleCallbacks;

    /**
     * @return bool
     */
    public function getForceCover(): bool
    {
        return $this->forceCover;
    }

    /**
     * @param bool $forceCover
     * @return $this
     */
    public function setForceCover(bool $forceCover): TemplateGenerator
    {
        $this->forceCover = $forceCover;

        return $this;
    }

    /**
     * @return string
     */
    public function getSaveDirectory(): string
    {
        return $this->saveDirectory;
    }

    /**
     * @param string $saveDirectory
     * @return $this
     */
    public function setSaveDirectory(string $saveDirectory): TemplateGenerator
    {
        $this->saveDirectory = $saveDirectory;

        return $this;
    }

    /**
     * @return string
     */
    public function getSaveFilename(): string
    {
        return $this->saveFilename;
    }

    /**
     * @param string $saveFilename
     * @return $this
     */
    public function setSaveFilename(string $saveFilename): TemplateGenerator
    {
        $this->saveFilename = $saveFilename;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceTemplateFile(): string
    {
        return $this->sourceTemplateFile;
    }

    /**
     * @param string $sourceTemplateFile
     * @return $this
     */
    public function setSourceTemplateFile(string $sourceTemplateFile): TemplateGenerator
    {
        $this->sourceTemplateFile = $sourceTemplateFile;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getReplacementRules(): array
    {
        return $this->replacementRules;
    }

    /**
     * @param string[] $replacementRules
     * @return $this
     */
    public function setReplacementRules(array $replacementRules): TemplateGenerator
    {
        $this->replacementRules = $replacementRules;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getReplacementRuleCallbacks(): array
    {
        return $this->replacementRuleCallbacks;
    }

    /**
     * @param array $replacementRuleCallbacks
     * @return $this
     */
    public function setReplacementRuleCallbacks(array $replacementRuleCallbacks): TemplateGenerator
    {
        $this->replacementRuleCallbacks = $replacementRuleCallbacks;

        return $this;
    }


    /**
     * @desc 获取写入结果
     * @return bool
     */
    public function getWriteResult(): bool
    {
        // 文件读取实例
        $reader = new TemplateFileReader($this->getSourceTemplateFile());
        // 替换引擎实例
        $engine = new TemplateEngine($reader);
        // 初始化参数
        $engine->setContentReplacements($this->getReplacementRules())->setContentReplacementsCallback($this->getReplacementRuleCallbacks());
        // 执行替换
        $engine->replaceContentReplacements()->replaceContentReplacementsCallback();
        // 文件写入实例
        $writer = new TemplateFileWriter($this->getSaveFilename());
        // 写入并保存文件
        $result = $writer->setContent($engine->getReplaceResult())->setForce($this->getForceCover())->saveFile();

        return $result;
    }

    /**
     * @desc 获取替换结果
     * @return string
     */
    public function getReplaceResult(): string
    {
        //
        $reader = new TemplateFileReader($this->getSourceTemplateFile());
        //
        $engine = new TemplateEngine($reader);
        //
        $engine->setContentReplacements($this->getReplacementRules())->setContentReplacementsCallback($this->getReplacementRuleCallbacks());
        //
        $engine->replaceContentReplacements()->replaceContentReplacementsCallback();

        return $engine->getReplaceResult();
    }
}
