<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\Route;
use Mrzkit\LaravelCodeGenerator\Templates\RouteTemplates\RouteReplace;

class RouteTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var string
     */
    private $controlName;

    /**
     * @var TemplateHandlerContract
     */
    private $templateHandlerContract;

    public function __construct(string $controlName, TemplateHandlerContract $templateHandlerContract)
    {
        $this->controlName             = $controlName;
        $this->templateHandlerContract = $templateHandlerContract;
    }

    protected function createRoute() : TemplateHandleContract
    {
        return new Route($this->controlName);
    }

    protected function createRouteReplace(string $content) : TemplateHandleContract
    {
        return new RouteReplace($this->controlName, $content,);
    }

    public function handle() : array
    {
        $result = [];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createRoute()->handle());

        $replaceString = $templateHandler->getReplaceResult();

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createRouteReplace($replaceString)->handle());

        $result[] = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        return $result;
    }

}
