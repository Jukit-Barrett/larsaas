<?php

namespace Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateGeneration;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\TemplateGenerator;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;

class Route implements TemplateHandleContract
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

        $namespacePath = static::processNamespacePath($fullControlName);

        $controlPathName = Str::snake($controlName, '-');

        // ************************************

        // 模板和写入文件都是自己
        $routePath = app()->basePath("routes") . '/'  . 'api.php';

        if (!file_exists($routePath)) {
            // 获取模板内容
            $tpl = file_get_contents(__DIR__ . '/tpl/RouteEmpty.tpl');
            // 写入
            if (file_put_contents($routePath, $tpl) === false) {
                throw new InvalidArgumentException('创建路由文件失败:' . $routePath);
            }
        }

        // 读取路由文件
        $content = file_get_contents($routePath);

        // 如果有此关键字，则不添加
        $force = true;
        if (preg_match("/{$controlName}/", $content)) {
            $force = false;
        }

        // 中间件
        $authMiddleware = $controlName === 'AdminSystem' ? 'auth:adm' : 'auth:api';

        //********************************************************

        // 是否强制覆盖: true=覆盖,false=不覆盖
        $forceCover = $force;

        // 保存目录
        $saveDirectory = app()->basePath("routes");

        // 保存文件名称
        $saveFilename = '/tmp/QWERTYUI1234XONB.log';

        // 模板文件
        $sourceTemplateFile = __DIR__ . '/tpl/Route.tpl';

        // 替换规则
        $replacementRules = [
            '/{{AUTH_MIDDLEWARE}}/' => $authMiddleware,
            '/{{NAMESPACE_PATH}}/' => $namespacePath,
            '/{{RNT}}/' => $controlName,
            '/{{LOWER_ROUTE_NAME}}/' => $controlPathName,
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
