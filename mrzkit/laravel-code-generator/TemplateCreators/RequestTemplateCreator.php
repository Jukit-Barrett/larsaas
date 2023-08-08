<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\BatchStoreRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\BatchUpdateRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\IndexRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\ManyRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\StoreRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\UpdateRequest;

class RequestTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var string
     */
    private $controlName;

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(string $controlName, TableInformationContract $tableInformationContract)
    {
        $this->controlName              = $controlName;
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createIndexRequest(): TemplateHandleContract
    {
        return new IndexRequest($this->controlName);
    }


    protected function createStoreRequest(): TemplateHandleContract
    {
        return new StoreRequest($this->controlName, $this->tableInformationContract);
    }

    protected function createUpdateRequest(): TemplateHandleContract
    {
        return new UpdateRequest($this->controlName, $this->tableInformationContract);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->createIndexRequest()->handle();
        $result[]        = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        $templateHandler = $this->createStoreRequest()->handle();
        $result[]        = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        $templateHandler = $this->createUpdateRequest()->handle();
        $result[]        = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
