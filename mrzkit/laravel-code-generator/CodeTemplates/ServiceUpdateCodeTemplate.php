<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\DataTypeMatcher;

class ServiceUpdateCodeTemplate implements CodeTemplate
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    /**
     * @var array 忽略的字段
     */
    private $ignoreFields = [];

    /**
     * @var string 下标名称
     */
    private $itemName = "row";

    /**
     * @var string 变量名称
     */
    private $paramName = "params";

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

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): static
    {
        $this->itemName = $itemName;

        return $this;

    }

    public function getParamName(): string
    {
        return $this->paramName;
    }

    public function setParamName(string $paramName): static
    {
        $this->paramName = $paramName;

        return $this;

    }

    public function getCodeString(): string
    {
        $ignoreFields = $this->getIgnoreFields();
        $itemName     = $this->getItemName();
        $paramName    = $this->getParamName();

        $tableFullColumns = $this->tableInformationContract->getTableFullColumns();

        $codeString = "";
        foreach ($tableFullColumns as $column) {
            if (in_array($column->Field, $ignoreFields)) {
                continue;
            }

            $snakeField = Str::snake($column->Field);
            $camelField = Str::camel($column->Field);

            //****
            $matcher = new DataTypeMatcher($column->Field, $column->Type, $column->Comment);
            if (!empty($matcher->matchInt())) {
                $template = "
                    if (isset(\${$itemName}[\"%s\"])) {
                        \${$paramName}[\"%s\"] = %s (\${$itemName}[\"%s\"] ?? %d);
                    }
                ";
                $type     = "(int)";
                $val      = 0;
            } else if (!empty($matcher->matchFloat())) {
                $template = "
                    if (isset(\${$itemName}[\"%s\"])) {
                        \${$paramName}[\"%s\"] = %s (\${$itemName}[\"%s\"] ?? %2f);
                    }
                ";
                $type     = "(double)";
                $val      = 0.00;
            } else if (!empty($matcher->matchString())) {
                $template = "
                    if (isset(\${$itemName}[\"%s\"])) {
                        \${$paramName}[\"%s\"] = %s (\${$itemName}[\"%s\"] ?? %s);
                    }
                ";
                $type     = "(string)";
                $val      = "\"\"";
            } else if (!empty($matcher->matchDate())) {
                $template = "
                    if (isset(\${$itemName}[\"%s\"])) {
                        \${$paramName}[\"%s\"] = %s (\${$itemName}[\"%s\"] ?? %s);
                    }
                ";
                $type     = "";
                $val      = "null";
            } else {
                $template = "
                    if (isset(\${$itemName}[\"%s\"])) {
                        \${$paramName}[\"%s\"] = %s (\${$itemName}[\"%s\"] ?? %s),;
                    }
                ";
                $type     = "(string)";
                $val      = "";
            }
            $codeString .= sprintf($template, $camelField, $snakeField, $type, $camelField, $val, "\r\n");
            //****
        }

        return $codeString;
    }
}
