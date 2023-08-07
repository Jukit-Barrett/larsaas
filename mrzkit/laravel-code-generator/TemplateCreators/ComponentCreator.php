<?php

namespace Mrzkit\LaravelCodeGenerator\TemplateCreators;

use Mrzkit\LaravelCodeGenerator\Contracts\TemplateCreatorContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandleContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TemplateHandlerContract;
use Mrzkit\LaravelCodeGenerator\Templates\ComponentTemplates\Component;
use Mrzkit\LaravelCodeGenerator\Templates\ComponentTemplates\ComponentAbstract;
use Mrzkit\LaravelCodeGenerator\Templates\ComponentTemplates\ComponentContract;
use Mrzkit\LaravelCodeGenerator\Templates\ComponentTemplates\ComponentImpl;
use Mrzkit\LaravelCodeGenerator\Templates\ComponentTemplates\ComponentInterface;

class ComponentCreator implements TemplateCreatorContract
{
    /**
     * @var string
     */
    private $componentName;

    /**
     * @var TemplateHandlerContract
     */
    private $templateHandlerContract;

    public function __construct(string $componentName, TemplateHandlerContract $templateHandlerContract)
    {
        $this->componentName           = $componentName;
        $this->templateHandlerContract = $templateHandlerContract;
    }

    protected function createComponent() : TemplateHandleContract
    {
        return new Component($this->componentName);
    }

    protected function createComponentAbstract() : TemplateHandleContract
    {
        return new ComponentAbstract('ComponentAbstract');
    }

    protected function createContract() : TemplateHandleContract
    {
        return new ComponentContract('ComponentContract');
    }

    protected function createComponentImpl() : TemplateHandleContract
    {
        return new ComponentImpl($this->componentName);
    }

    protected function createComponentInterface() : TemplateHandleContract
    {
        return new ComponentInterface($this->componentName);
    }

    public function handle() : array
    {
        $result = [];

        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createComponent()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];
        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createComponentAbstract()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];
        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createContract()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];
        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createComponentImpl()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];
        $templateHandler = $this->templateHandlerContract->setTemplateContract($this->createComponentInterface()->handle());
        $result[]        = [
            'result'       => $templateHandler->getWriteResult(),
            'saveFilename' => $templateHandler->getTemplateContract()->getSaveFilename(),
        ];

        return $result;
    }
}
