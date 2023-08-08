<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Templates\ControllerTemplates\Controller;

class ControllerTemplateCreator implements TemplateCreatorContract
{
    /**
     * @var string
     */
    private $controlName;

    public function __construct(string $controlName)
    {
        $this->controlName = $controlName;
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

        $templateHandler = $this->createController()->handle();

        $result[] = [
            'result' => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getSaveFilename(),
        ];

        return $result;
    }
}
