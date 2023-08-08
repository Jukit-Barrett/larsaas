<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;

class ModelFillableCodeTemplate implements CodeTemplate
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    /**
     * @var array 忽略字段
     */
    private $ignoreFields = [];

    public function __construct(TableInformationContract $tableInformationContract)
    {
        $this->tableInformationContract = $tableInformationContract;
    }

    public function getIgnoreFields(): array
    {
        return $this->ignoreFields;
    }

    public function setIgnoreFields(array $ignoreFields): static
    {
        $this->ignoreFields = $ignoreFields;

        return $this;
    }

    public function getCodeString(): string
    {
        $tableFields = $this->tableInformationContract->getTableFields();

        return "'" . implode("', '", $tableFields) . "',";
    }
}
