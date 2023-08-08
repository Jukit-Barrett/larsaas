<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\ModelTemplates;

use Mrzkit\LaravelCodeGenerator\CodeTemplates\ModelFillableCodeTemplate;
use Mrzkit\LaravelCodeGenerator\CodeTemplates\ShardConfigCodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateObject;

class Model implements TemplateHandleContract
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    /**
     * @return TableInformationContract
     */
    public function getTableInformationContract()
    {
        return $this->tableInformationContract;
    }

    public function handle(): TemplateContract
    {
        $tableInformationContract = $this->getTableInformationContract();

        $tableName = $tableInformationContract->getRenderTableName();

        $modelFillableCodeTemplate = new ModelFillableCodeTemplate($this->tableInformationContract);

        $shardConfigCodeTemplate = new ShardConfigCodeTemplate($this->tableInformationContract);

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Repositories/{$tableName}");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $tableName . '.php';

        // 模板文件
        if ($tableInformationContract->getTableShard()) {
            $sourceTemplateFile = __DIR__ . '/stpl/Model.tpl';
        } else {
            $sourceTemplateFile = __DIR__ . '/tpl/Model.tpl';
        }

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $tableName,
            '/{{FILL_ABLE_TPL}}/' => $modelFillableCodeTemplate->getCodeString(),
            '/{{MAX_SHARD_COUNT}}/' => $tableInformationContract->getMaxShardCount(),
            '/{{SHARD_CONFIG_TPL}}/' => $shardConfigCodeTemplate->getCodeString(),
        ];

        // 替换规则-回调
        $replacementRuleCallbacks = [

        ];

        $templateObject = new TemplateObject();

        $templateObject->setForceCover($forceCover)
            ->setSaveDirectory($saveDirectory)
            ->setSaveFilename($saveFilename)
            ->setSourceTemplateFile($sourceTemplateFile)
            ->setReplacementRules($replacementRules)
            ->setReplacementRuleCallbacks($replacementRuleCallbacks);

        return $templateObject;
    }

}