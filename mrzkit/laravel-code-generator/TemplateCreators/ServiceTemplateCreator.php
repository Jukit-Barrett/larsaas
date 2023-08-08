<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\ServiceTemplates\Service;

class ServiceTemplateCreator implements TemplateCreatorContract
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

    protected function createService(): TemplateHandleContract
    {
        return new Service($this->controlName, $this->tableInformationContract);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->createService()->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
