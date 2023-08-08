<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RepositoryFactoryTemplates;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class RepositoryFactoryEmpty implements TemplateHandleContract
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

        // ************************************

        // 模板和写入文件都是自己
        $path = app()->basePath("app/Support/Factories") . '/'  . 'RepositoryFactory.php';

        if (!file_exists($path)) {
            // 获取模板内容
            $tpl = file_get_contents(__DIR__ . '/tpl/RepositoryFactoryEmpty.tpl');
            // 写入
            if (file_put_contents($path, $tpl) === false) {
                throw new InvalidArgumentException('创建文件失败:' . $path);
            }
        }

        // 读取路由文件
        $content = file_get_contents($path);

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = true;

        // 保存目录
        $saveDirectory = app()->basePath("routes");

        // 保存文件名称
        $saveFilename = '/tmp/QWERTYUI1234XONB.log';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/RepositoryFactory.tpl';

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
