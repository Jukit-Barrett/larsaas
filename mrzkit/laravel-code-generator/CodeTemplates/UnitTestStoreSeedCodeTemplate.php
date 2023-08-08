<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\DataTypeMatcher;

class UnitTestStoreSeedCodeTemplate implements CodeTemplate
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

    public function getCodeString(array $ignoreFields = []): string
    {
        $tableFullColumns = $this->tableInformationContract->getTableFullColumns();

        $codeString = "";
        foreach ($tableFullColumns as $column) {
            if (in_array($column->Field, $ignoreFields)) {
                continue;
            }
            $camelField = Str::camel($column->Field);

            //****
            $matcher = new DataTypeMatcher($column->Field, $column->Type, $column->Comment);
            if (!empty($matchResult = $matcher->matchInt())) {
                $max      = $matchResult["max"] ?? 2147483647;
                $template = '"%s" => %s %s,%s';
                $type     = "(int)";
                $val      = "random_int(0, {$max})";
            } else if (!empty($matchResult = $matcher->matchFloat())) {
                $max      = $matchResult["max"] ?? 2147483647;
                $template = '"%s" => %s %s,%s';
                $type     = "(double)";
                $val      = "random_int(0, {$max})";
            } else if (!empty($matchResult = $matcher->matchString())) {
                $max      = $matchResult["max"] ?? 100;
                $template = '"%s" => %s %s,%s';
                $type     = "(string)";
                $val      = "addslashes(\$this->getFaker()->realTextBetween(5, {$max}))";
            } else if (!empty($matchResult = $matcher->matchDate())) {
                $template = '"%s" => %s %s,%s';
                $type     = "";
                $val      = "date('Y-m-d H:i:s')";
            } else {
                $template = '"%s" => %s %s,%s';
                $type     = "(string)";
                $val      = "addslashes(\$this->getFaker()->realTextBetween(5, 100))";
            }
            $codeString .= sprintf($template, $camelField, $type, $val, "\r\n");
            //****
        }

        return $codeString;
    }
}
