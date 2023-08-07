<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\LaravelCodeGenerator\Templates\ControllerTemplates\Controller;

class ControllerTemplateCreator implements TemplateCreatorContract
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

    /**
     * @desc 返回创建控制器的实例
     * @return TemplateHandleContract
     */
    protected function createController(): TemplateHandleContract
    {
        return new Controller($this->controlName);
    }

    public function handle(): array
    {
        $result = [];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createController()->handle());

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        return $result;
    }
}
