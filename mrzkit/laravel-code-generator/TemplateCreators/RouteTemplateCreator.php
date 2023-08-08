<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\Route;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\RouteReplace;

class RouteTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var string
     */
    private $controlName;

    public function __construct(string $controlName)
    {
        $this->controlName = $controlName;
    }

    protected function createRoute(): TemplateHandleContract
    {
        return new Route($this->controlName);
    }

    protected function createRouteReplace(string $content): TemplateHandleContract
    {
        return new RouteReplace($this->controlName, $content,);
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
