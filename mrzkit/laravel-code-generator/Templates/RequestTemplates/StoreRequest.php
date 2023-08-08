<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates;

use Mrzkit\LaravelCodeGenerator\CodeTemplates\RequestStoreMessageCodeTemplate;
use Mrzkit\LaravelCodeGenerator\CodeTemplates\RequestStoreRuleCodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class StoreRequest implements TemplateHandleContract
{
    use TemplateUtil;

    /**
     * @var string
     */
    private $controlName;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(string $controlName, TableInformationContract $tableInformationContract)
    {
        $this->controlName              = $controlName;
        $this->tableInformationContract = $tableInformationContract;
    }

    /**
     * @return string
     */
    public function getControlName(): string
    {
        return $this->controlName;
    }

    /**
     * @desc
     * @return string[]
     */
    public function getIgnoreFields(): array
    {
        return [
            "id", "createdBy", "createdAt", "updatedBy", "updatedAt", "deletedBy", "deletedAt",
            "id", "created_by", "created_at", "updated_by", "updated_at", "deleted_by", "deleted_at",
            "tenant_id", "tenantId",
        ];
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->getControlName();

        $controlName = static::processControlName($fullControlName);

        $namespacePath = static::processNamespacePath($fullControlName);

        $directoryPath = static::processDirectoryPath($fullControlName);

        $requestStoreRuleCodeTemplate = new RequestStoreRuleCodeTemplate($this->tableInformationContract);

        $requestStoreRuleCodeTemplate->setIgnoreFields($this->getIgnoreFields());

        $requestStoreMessageCodeTemplate = new RequestStoreMessageCodeTemplate($this->tableInformationContract);

        $requestStoreMessageCodeTemplate->setIgnoreFields($this->getIgnoreFields());

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Http/Controllers/{$directoryPath}{$controlName}Controls/Requests");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $controlName . 'StoreRequest.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/StoreRequest.tpl';

        // 替换规则
        $replacementRules = [
            '/{{NAMESPACE_PATH}}/' => $namespacePath,
            '/{{RNT}}/' => $controlName,
            '/{{REQUEST_STORE_RULE_TPL}}/' => $requestStoreRuleCodeTemplate->getCodeString(),
            '/{{REQUEST_STORE_MESSAGE_TPL}}/' => $requestStoreMessageCodeTemplate->getCodeString(),
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
