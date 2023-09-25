<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class RouteReplace implements TemplateHandleContract
{
    use TemplateUtil;

    /**
     * @var string
     */
    private $content;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract, string $content)
    {
        $this->tableInformationContract = $tableInformationContract;
        $this->content = $content;
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->tableInformationContract->getRenderTableName();

        $firstControlName = static::processFirstControlName($fullControlName);

        $controlName = static::processControlName($fullControlName);

        $firstControlNameCamel = Str::camel($firstControlName);

        //*******************************************************

        // 模板和写入文件都是自己
        $routePath = app()->basePath("routes") . '/'  . 'api.php';

        if (!file_exists($routePath)) {
            throw new \InvalidArgumentException('路由文件不存在:' . $routePath);
        }

        // 读取路由文件
        $content = file_get_contents($routePath);

        // 如果有此关键字，则不添加
        $force = true;
        if (preg_match("/{$controlName}/", $content)) {
            $force = false;
        }

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = $force;

        // 保存目录
        $saveDirectory = app()->basePath("app/Components/{$firstControlNameCamel}");

        // 保存文件名称
        $saveFilename = $routePath;

        // 模板文件
        $sourceTemplateFile = $routePath;

        // 替换规则
        $replacementRules = [
            '/\\/\\/{{HERE}}/' => $this->content,
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
