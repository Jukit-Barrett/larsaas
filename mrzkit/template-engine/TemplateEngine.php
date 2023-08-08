<?php

namespace Mrzkit\TemplateEngine;

use Mrzkit\TemplateEngine\Contracts\TemplateFileContract;

class TemplateEngine
{
    /**
     * @var array 替换正则
     */
    protected $contentReplacements = [];

    /**
     * @var array 替换正则 - 回调
     */
    protected $contentReplacementsCallback = [];

    /**
     * @var string 替换结果
     */
    protected $replaceResult = '';

    /**
     * @var TemplateFileContract
     */
    protected $templateFile;

    public function __construct(TemplateFileContract $templateFile)
    {
        $this->templateFile = $templateFile;

        // 使用原始模板内容作为初始化替换结果
        $this->setReplaceResult($templateFile->getContent());
    }

    /**
     * @desc 设置替换正则
     * @param array $crs
     * @return $this
     */
    public function setContentReplacements(array $crs)
    {
        $this->contentReplacements = $crs;

        return $this;
    }

    /**
     * @desc 获取替换正则
     * @return array
     */
    public function getContentReplacements() : array
    {
        return $this->contentReplacements;
    }

    /**
     * @desc 执行正则替换
     * @return $this
     */
    public function replaceContentReplacements()
    {
        // 替换规则(数组)
        $contentReplacements = $this->getContentReplacements();

        if (empty($contentReplacements)) {
            return $this;
        }

        $patterns = array_keys($contentReplacements);

        $replacements = array_values($contentReplacements);

        // 保存替换结果
        $replaceResult = preg_replace($patterns, $replacements, $this->getReplaceResult());

        $this->setReplaceResult($replaceResult);

        return $this;
    }

    /**
     * @desc 设置替换正则-回调
     * @param array $crs
     * @return $this
     */
    public function setContentReplacementsCallback(array $crs)
    {
        $this->contentReplacementsCallback = $crs;

        return $this;
    }

    /**
     * @desc 获取替换正则-回调
     * @return array
     */
    public function getContentReplacementsCallback() : array
    {
        return $this->contentReplacementsCallback;
    }

    /**
     * @desc 执行正则替换 - 回调
     * @return $this
     */
    public function replaceContentReplacementsCallback()
    {
        // 替换规则(回调)
        $contentReplacements = $this->getContentReplacementsCallback();

        if (empty($contentReplacements)) {
            return $this;
        }

        // 保存替换结果
        $replaceResult = preg_replace_callback_array($contentReplacements, $this->getReplaceResult());

        $this->setReplaceResult($replaceResult);

        return $this;
    }

    /**
     * @desc 设置替换结果
     * @param string $replaceResult
     * @return $this
     */
    protected function setReplaceResult(string $replaceResult)
    {
        $this->replaceResult = $replaceResult;

        return $this;
    }

    /**
     * @desc 获取替换结果
     * @return string
     */
    public function getReplaceResult() : string
    {
        return $this->replaceResult;
    }
}
