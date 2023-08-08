<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\DataTypeMatcher;

class UnitTestStoreCodeTemplate implements CodeTemplate
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
        $ignoreFields = $this->getIgnoreFields();

        $tableFullColumns = $this->tableInformationContract->getTableFullColumns();

        /** @var \Faker\Generator::class $faker */
        $faker = app(\Faker\Generator::class);

        $codeString = "";
        foreach ($tableFullColumns as $column) {
            if (in_array($column->Field, $ignoreFields)) {
                continue;
            }
            $camelField = Str::camel($column->Field);

            //****
            $matcher = new DataTypeMatcher($column->Field, $column->Type, $column->Comment);
            if (!empty($matchResult = $matcher->matchInt())) {
                $template = '"%s" => %s %d,%s';
                $type     = "(int)";
                $val      = random_int(0, $matchResult["max"] ?? 2147483647);
            } else if (!empty($matcher->matchFloat())) {
                $template = '"%s" => %s %2f,%s';
                $type     = "(double)";
                $val      = random_int(0, $matchResult["max"] ?? 2147483647);;
            } else if (!empty($matcher->matchString())) {
                $text     = $faker->realTextBetween(5, 100);
                $text     = str_replace('"', '', $text);
                $text     = addslashes($text);
                $template = '"%s" => %s %s,%s';
                $type     = "(string)";
                $val      = "\"{$text}\"";
            } else if (!empty($matcher->matchDate())) {
                $template = '"%s" => %s %s,%s';
                $type     = "";
                $val      = "date('Y-m-d H:i:s')";
            } else {
                $text     = $faker->realTextBetween(5, 100);
                $text     = str_replace('"', '', $text);
                $text     = addslashes($text);
                $template = '"%s" => %s %s,%s';
                $type     = "(string)";
                $val      = "{$text}";
            }
            $codeString .= sprintf($template, $camelField, $type, $val, "\r\n");
            //****
        }

        return $codeString;
    }

}
