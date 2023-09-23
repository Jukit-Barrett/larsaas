<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryFactoryTemplates\RepositoryFactoryReplace;

class FactoryTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createRepositoryFactoryEmpty(): TemplateHandleContract
    {
        return new RepositoryFactoryEmpty($this->tableInformationContract);
    }

    protected function createRepositoryFactoryReplace(string $content): TemplateHandleContract
    {
        return new RepositoryFactoryReplace($this->tableInformationContract, $content);
    }

    public function handle(): array
    {

        $result = [];

        // 处理
        $templateHandler = $this->createRepositoryFactoryEmpty()->handle();

        // 获取替换结果
        $replaceString = $templateHandler->getReplaceResult();

        // 添加替换结果再处理
        $templateHandler = $this->createRepositoryFactoryReplace($replaceString)->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
