<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RepositoryTemplates\Repository;

class RepositoryTemplateCreator implements TemplateCreatorContract
{

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createModelRepository(): TemplateHandleContract
    {
        return new Repository($this->tableInformationContract);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->createModelRepository()->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
