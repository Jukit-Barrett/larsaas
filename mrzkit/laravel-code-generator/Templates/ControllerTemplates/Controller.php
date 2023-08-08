<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\ControllerTemplates;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class Controller implements TemplateHandleContract
{
    use TemplateUtil;

    /**
     * @var string 控制器名称
     */
    private $controlName;

    public function __construct(string $controlName)
    {
        $this->controlName = $controlName;
    }

    /**
     * @return string
     */
    public function getControlName(): string
    {
        return $this->controlName;
    }

    public function handle(): TemplateGeneration
    {
        $fullControlName = $this->getControlName();

        $controlName = static::processControlName($fullControlName);

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = false;

        // 保存目录
        $saveDirectory = app()->basePath("app/Http/Controllers");

        // 保存文件名称
        $saveFilename = $saveDirectory . '/' . $controlName . 'Controller.php';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/Controller.tpl';

        // 替换规则
        $replacementRules = [
            '/{{RNT}}/' => $controlName,
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
            //
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
