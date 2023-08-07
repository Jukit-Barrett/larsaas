<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates;

use Mrzkit\LaravelCodeGenerator\CodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateObject;
use Mrzkit\LaravelCodeGenerator\TemplateTool;

class BatchUpdateRequest implements TemplateHandleContract
{
    use TemplateTool;

    /**
     * @var string
     */
    private $controlName;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    private $codeTemplate;

    public function __construct(string $controlName, TableInformationContract $tableInformationContract)
    {
        $this->controlName              = $controlName;
        $this->tableInformationContract = $tableInformationContract;
        $this->codeTemplate             = new CodeTemplate($tableInformationContract);
    }

    /**
     * @return string
     */
    public function getControlName() : string
    {
        return $this->controlName;
    }

    /**
     * @return TableInformationContract
     */
    public function getTableInformationContract() : TableInformationContract
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
            "createdBy", "createdAt", "updatedBy", "updatedAt", "deletedBy", "deletedAt",
            "created_by", "created_at", "updated_by", "updated_at", "deleted_by", "deleted_at",
            "tenant_id", "tenantId",
        ];
    }

    public function handle() : TemplateContract
    {
        $fullControlName = $this->getControlName();

        $controlName = static::processControlName($fullControlName);

        $namespacePath = static::processNamespacePath($fullControlName);

        $directoryPath = static::processDirectoryPath($fullControlName);

        $requestTemplateRenderContract = $this->getCodeTemplate()->getRequestUpdateTpl($this->getIgnoreFields(), true);

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Http/Controllers/{$directoryPath}{$controlName}Controls/Requests");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $controlName . 'BatchUpdateRequest.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/BatchUpdateRequest.tpl';

        // 替换规则
        $replacementRules = [
            '/{{NAMESPACE_PATH}}/'                   => $namespacePath,
            '/{{RNT}}/'                              => $controlName,
            '/{{REQUEST_BATCH_UPDATE_RULE_TPL}}/'    => $requestTemplateRenderContract->getRuleString(),
            '/{{REQUEST_BATCH_UPDATE_MESSAGE_TPL}}/' => $requestTemplateRenderContract->getMessageString(),
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
