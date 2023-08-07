<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

use Mrzkit\LaravelCodeGenerator\TemplateHandler;

interface TemplateHandlerContract
{
    /**
     * @return TemplateContract
     */
    public function getTemplateContract() : TemplateContract;

    /**
     * @param TemplateContract $templateContract
     */
    public function setTemplateContract(TemplateContract $templateContract) : TemplateHandler;

    /**
     * @desc
     * @return bool
     */
    public function getWriteResult() : bool;

    /**
     * @desc
     * @return string
     */
    public function getReplaceResult() : string;

}
