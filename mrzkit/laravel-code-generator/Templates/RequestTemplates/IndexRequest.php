<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class IndexRequest implements TemplateHandleContract
{
    use TemplateUtil;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->tableInformationContract->getRenderTableName();

        $controlName = static::processControlName($fullControlName);

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Http/Requests/{$controlName}");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . "Index{$controlName}Request.php";

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/IndexRequest.tpl';

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $controlName,
        ];

        // 替换规则-回调
        $replacementRuleCallbacks = [

        ];

        $templateGenerator = new TemplateGenerator();

        $templateGenerator->setForceCover($forceCover)
            ->setSaveDirectory($saveDirectory)
            ->setSaveFilename($saveFilename)
            ->setSourceTemplateFile($sourceTemplateFile)
            ->setReplacementRules($replacementRules)
            ->setReplacementRuleCallbacks($replacementRuleCallbacks);

        return $templateGenerator;
    }

}
