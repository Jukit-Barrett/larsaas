<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates;

use Mrzkit\LaravelCodeGenerator\CodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateObject;

class ModelRepositoryFactory implements TemplateHandleContract
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    /**
     * @var CodeTemplate
     */
    private $codeTemplate;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;

        $this->codeTemplate = new CodeTemplate($tableInformationContract);
    }

    /**
     * @return TableInformationContract
     */
    public function getTableInformationContract()
    {
        return $this->tableInformationContract;
    }

    /**
     * @return CodeTemplate
     */
    public function getCodeTemplate() : CodeTemplate
    {
        return $this->codeTemplate;
    }

    /**
     * @desc
     * @return string[]
     */
    public function getIgnoreFields() : array
    {
        return [
            "deletedBy", "deletedAt",
            "deleted_by", "deleted_at",
        ];
    }

    public function handle() : TemplateContract
    {
        $tableName = $this->getCodeTemplate()->getRenderTableName();

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Repositories/{$tableName}");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $tableName . 'RepositoryFactory.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/ModelRepositoryFactory.tpl';

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $tableName,
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
