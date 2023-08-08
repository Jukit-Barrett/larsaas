<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\UnitTestTemplates\UnitTest;

class UnitTestTemplateCreator implements TemplateCreatorContract
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

    protected function createUnitTest(): TemplateHandleContract
    {
        return new UnitTest($this->controlName, $this->tableInformationContract);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->createUnitTest()->handle();
        $result[]        = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }
}
