<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\Repository;

class RepositoryTemplateCreator implements TemplateCreatorContract
{

    /**
     * @var TemplateHandlerContract
     */
    private $templateHandlerContract;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TemplateHandlerContract $templateHandlerContract, TableInformationContract $tableInformationContract)
    {
        $this->templateHandlerContract  = $templateHandlerContract;
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createModelRepository(): TemplateHandleContract
    {
        return new Repository($this->tableInformationContract);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createModelRepository()->handle());
        $result[]        = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        return $result;
    }

}
