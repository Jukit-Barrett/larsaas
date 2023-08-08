<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\Route;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\RouteReplace;

class RouteTemplateCreator implements TemplateCreatorContract
{

    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    protected function createRoute(): TemplateHandleContract
    {
        return new Route($this->tableInformationContract);
    }

    protected function createRouteReplace(string $content): TemplateHandleContract
    {
        return new RouteReplace($this->tableInformationContract, $content);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->createRoute()->handle();

        $replaceString = $templateHandler->getReplaceResult();

        $templateHandler = $this->createRouteReplace($replaceString)->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }

}
