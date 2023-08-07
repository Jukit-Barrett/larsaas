<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\Model;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\ModelRepository;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\ModelRepositoryComplex;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\ModelRepositoryFactory;

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

    protected function createModel() : TemplateHandleContract
    {
        return new Model($this->tableInformationContract);
    }

    protected function createModelRepository() : TemplateHandleContract
    {
        return new ModelRepository($this->tableInformationContract);
    }

    protected function createModelRepositoryComplex() : TemplateHandleContract
    {
        return new ModelRepositoryComplex($this->tableInformationContract);
    }

    protected function createModelRepositoryFactory() : TemplateHandleContract
    {
        return new ModelRepositoryFactory($this->tableInformationContract);
    }

    public function handle() : array
    {
        $result = [];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createModel()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createModelRepository()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createModelRepositoryComplex()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createModelRepositoryFactory()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        return $result;
    }

}
