<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\ServiceFactoryTemplates\ServiceFactoryEmpty;
use Mrzkit\LaravelCodeGenerator\Templates\ServiceFactoryTemplates\ServiceFactoryReplace;

class ServiceFactoryTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function ServiceFactoryEmpty(): TemplateHandleContract
    {
        return new ServiceFactoryEmpty($this->tableInformationContract);
    }

    protected function createServiceFactoryReplace(string $content): TemplateHandleContract
    {
        return new ServiceFactoryReplace($this->tableInformationContract, $content);
    }

    public function handle(): array
    {


        $result = [];

        // 处理
        $templateHandler = $this->ServiceFactoryEmpty()->handle();

        // 获取替换结果
        $replaceString = $templateHandler->getReplaceResult();

        // 添加替换结果再处理
        $templateHandler = $this->createServiceFactoryReplace($replaceString)->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
