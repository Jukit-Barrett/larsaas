<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;

class Repository implements TemplateHandleContract
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

    /**
     * @desc
     * @return string[]
     */
    public function getIgnoreFields(): array
    {
        return [
            "deletedBy", "deletedAt",
            "deleted_by", "deleted_at",
        ];
    }

    public function handle(): TemplateGeneration
    {
        $tableName = $this->tableInformationContract->getRenderTableName();

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Repositories/{$tableName}");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $tableName . 'Repository.php';

        // 模板文件
        if ($this->getTableInformationContract()->getTableShard()) {
            $sourceTemplateFile = __DIR__ . '/stpl/ModelRepository.tpl';
        } else {
            $sourceTemplateFile = __DIR__ . '/tpl/ModelRepository.tpl';
        }

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $tableName,
        ];

        // 替换规则-回调
        $replacementRuleCallbacks = [
            '/(\->)(\\$)(\w+)/' => function ($match) {
                $symbol    = $match[1];
                $tableName = $match[3];
                $humpName  = strtolower(substr($tableName, 0, 2)) . substr($tableName, 2);

                return $symbol . $humpName;
            },
            '/(\\$)(\w+)/' => function ($match) {
                $symbolDollar = $match[1];
                $tableName    = $match[2];
                $humpName     = strtolower(substr($tableName, 0, 1)) . substr($tableName, 1);

                return $symbolDollar . $humpName;
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
