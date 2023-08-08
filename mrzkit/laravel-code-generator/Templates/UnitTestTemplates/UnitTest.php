<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\UnitTestTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\CodeTemplates\UnitTestStoreCodeTemplate;
use Mrzkit\LaravelCodeGenerator\CodeTemplates\UnitTestStoreSeedCodeTemplate;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class UnitTest implements TemplateHandleContract
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
            "tenant_id", "tenantId",
        ];
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->tableInformationContract->getRenderTableName();

        $controlName = static::processControlName($fullControlName);

        //********************************************************

        $unitTestStoreCodeTemplate = new UnitTestStoreCodeTemplate($this->tableInformationContract);
        $unitTestStoreCodeTemplate->setIgnoreFields($this->getIgnoreFields());

        $unitTestStoreSeedCodeTemplate = new UnitTestStoreSeedCodeTemplate($this->tableInformationContract);
        $unitTestStoreSeedCodeTemplate->setIgnoreFields($this->getIgnoreFields());

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("tests/Feature");

        $saveDirectory = rtrim($saveDirectory, '/');

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $controlName . 'ControllerTest.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/UnitTest.tpl';

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $controlName,
            '/{{RNT_ROUTE_PATH}}/' => Str::snake($controlName, '-'),
            '/{{UNIT_TEST_STORE_CODE}}/' => $unitTestStoreCodeTemplate->getCodeString(),
            '/{{UNIT_TEST_STORE_SEED_TPL}}/' => $unitTestStoreSeedCodeTemplate->getCodeString(),
        ];

        // 替换规则-回调
        $replacementRuleCallbacks = [
            // 将 $Good 替换为 ->good
            '/(\\$)(' . $controlName . ')/' => function ($match) {
                //$full   = $match[0];
                $symbol   = $match[1];
                $name     = $match[2];
                $humpName = strtolower(substr($name, 0, 1)) . substr($name, 1);

                return $symbol . $humpName;
            },
            // 将 ->Good 替换为 ->good
            '/(\->)(' . $controlName . ')/' => function ($match) {
                //$full   = $match[0];
                $symbol = $match[1];
                $name   = $match[2];

                $humpName = strtolower(substr($name, 0, 1)) . substr($name, 1);

                return $symbol . $humpName;
            },
            '/(\->)(\\$)(\w+)/' => function ($match) {
                $symbol   = $match[1];
                $name     = $match[3];
                $humpName = strtolower(substr($name, 0, 2)) . substr($name, 2);

                return $symbol . $humpName;
            },
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
