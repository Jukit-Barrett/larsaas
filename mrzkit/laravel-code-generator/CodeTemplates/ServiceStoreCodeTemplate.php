<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\DataTypeMatcher;

class ServiceStoreCodeTemplate implements CodeTemplate
{
    /**
     * @var TableInformationContract
     */
    private $tableInformationContract;

    /**
     * @var array 忽略字段
     */
    private $ignoreFields = [];

    /**
     * @var string 下标名称
     */
    private $itemName = "";

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

    public function getCodeString(): string
    {
        $ignoreFields = $this->getIgnoreFields();

        $itemName = '$' . $this->getItemName();

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
                $template = '"%s" => %s (%s["%s"] ?? %d),%s';
                $type     = "(int)";
                $val      = 0;
            } else if (!empty($matcher->matchFloat())) {
                $template = '"%s" => %s (%s["%s"] ?? %2f),%s';
                $type     = "(double)";
                $val      = 0.00;
            } else if (!empty($matcher->matchString())) {
                $template = '"%s" => %s (%s["%s"] ?? %s),%s';
                $type     = "(string)";
                $val      = "\"\"";
            } else if (!empty($matcher->matchDate())) {
                $template = '"%s" => %s (%s["%s"] ?? %s),%s';
                $type     = "";
                $val      = "null";
            } else {
                $template = '"%s" => %s (%s["%s"] ?? %s),%s';
                $type     = "(string)";
                $val      = "";
            }
            $codeString .= sprintf($template, $snakeField, $type, $itemName, $camelField, $val, "\r\n");
            //****
        }

        return $codeString;
    }


}
