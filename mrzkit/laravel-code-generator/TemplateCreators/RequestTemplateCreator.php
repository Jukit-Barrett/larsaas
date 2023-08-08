<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\IndexRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\StoreRequest;
use Mrzkit\LaravelCodeGenerator\Templates\RequestTemplates\UpdateRequest;

class RequestTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createIndexRequest(): TemplateHandleContract
    {
        return new IndexRequest($this->tableInformationContract->getRenderTableName());
    }


    protected function createStoreRequest(): TemplateHandleContract
    {
        return new StoreRequest($this->tableInformationContract->getRenderTableName(), $this->tableInformationContract);
    }

    protected function createUpdateRequest(): TemplateHandleContract
    {
        return new UpdateRequest($this->tableInformationContract->getRenderTableName(), $this->tableInformationContract);
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
