<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\ServiceTemplates;

use Mrzkit\LaravelCodeGenerator\CodeTemplates\ServiceStoreCodeTemplate;
use Mrzkit\LaravelCodeGenerator\CodeTemplates\ServiceUpdateCodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class Service implements TemplateHandleContract
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

    /**
     * @desc
     * @return string[]
     */
    public function getIgnoreFields(): array
    {
        return [
            "id", "createdBy", "createdAt", "updatedBy", "updatedAt", "deletedBy", "deletedAt",
            "id", "created_by", "created_at", "updated_by", "updated_at", "deleted_by", "deleted_at",
        ];
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->tableInformationContract->getRenderTableName();

        $controlName = static::processControlName($fullControlName);

        $namespacePath = static::processNamespacePath($fullControlName);

        //********************************************************

        $serviceUpdateCodeTemplate = new ServiceUpdateCodeTemplate($this->tableInformationContract);
        $serviceUpdateString       = $serviceUpdateCodeTemplate->setIgnoreFields($this->getIgnoreFields())
            ->setItemName("inputParams")->setParamName("params")->getCodeString();


        $repositoryName = $this->tableInformationContract->getRenderTableName();

        $ServiceStoreCodeTemplate = new ServiceStoreCodeTemplate($this->tableInformationContract);
        $serviceStoreTpl          = $ServiceStoreCodeTemplate->setIgnoreFields($this->getIgnoreFields())
            ->setItemName("inputParams")->getCodeString();

        // 数据仓库名称
        $repository = "{$repositoryName}Repository";

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Services");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $controlName . 'Service.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/Service.tpl';

        // 替换规则
        $replacementRules = [
            '/{{NAMESPACE_PATH}}/' => $namespacePath,
            '/{{RNT}}/' => $controlName,
            '/{{SERVICE_UPDATE_TPL}}/' => $serviceUpdateString,
            '/{{SERVICE_STORE_TPL}}/' => $serviceStoreTpl,
            '/{{REPOSITORY}}/' => $repository,
            '/{{REPOSITORY_NAME}}/' => $repositoryName,
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
