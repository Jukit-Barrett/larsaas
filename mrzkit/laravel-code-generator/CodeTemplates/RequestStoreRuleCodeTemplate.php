<?php

namespace Mrzkit\LaravelCodeGenerator\CodeTemplates;

use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\DataTypeMatcher;

class RequestStoreRuleCodeTemplate implements CodeTemplate
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

    public function getCodeString(): string
    {
        $ignoreFields = $this->getIgnoreFields();

        $tableFullColumns = $this->tableInformationContract->getTableFullColumns();

        $dataTypeMatchers = collect([]);

        foreach ($tableFullColumns as $column) {
            // 跳过忽略的字符
            if (in_array($column->Field, $ignoreFields)) {
                continue;
            }
            // 实例化数据类型匹配器
            $dataTypeMatchers[] = new DataTypeMatcher($column->Field, $column->Type, $column->Comment);
        }

        $ruleString = "";

        $messageString = "";

        $batchTemplate = "";

        foreach ($dataTypeMatchers as $matcher) {
            // Integer
            $matchResult = $matcher->matchInt();
            if (!empty($matchResult)) {
                //
                $field = Str::camel($matcher->getField());
                // Rule
                $template   = '"%s%s"  => "required|integer|between:%d,%d",%s';
                $ruleString .= sprintf($template, $batchTemplate, $field, $matchResult["min"], $matchResult["max"], "\r\n");

                // Message
                $messageString .= "\"{$field}.required\" => \"缺少 {$field} 字段\",\r\n";
                $messageString .= "\"{$field}.integer\" => \"字段 {$field} 格式错误\",\r\n";
                $messageString .= "\"{$field}.between\" => \"字段 {$field} 超出范围\",\r\n";

                continue;
            }
            // Float
            $matchResult = $matcher->matchFloat();
            if (!empty($matchResult)) {
                //
                $field = Str::camel($matcher->getField());
                // Rule
                $template   = '"%s%s"  => "required|numeric",%s';
                $ruleString .= sprintf($template, $batchTemplate, $field, "\r\n");

                // Message
                $messageString .= "\"{$field}.required\" => \"缺少 {$field} 字段\",\r\n";
                $messageString .= "\"{$field}.numeric\" => \"字段 {$field} 格式错误\",\r\n";

                continue;
            }
            // String
            $matchResult = $matcher->matchString();
            if (!empty($matchResult)) {
                //
                $field = Str::camel($matcher->getField());
                // Rule
                $template   = '"%s%s" => "required|string|nullable|between:%d,%d",%s';
                $ruleString .= sprintf($template, $batchTemplate, $field, $matchResult["min"], $matchResult["max"], "\r\n");
                // Message
                $messageString .= "\"{$field}.required\" => \"缺少 {$field} 字段\",\r\n";
                $messageString .= "\"{$field}.string\" => \"字段 {$field} 格式错误\",\r\n";
                $messageString .= "\"{$field}.between\" => \"字段 {$field} 超出范围\",\r\n";

                continue;
            }

            // Date
            $matchResult = $matcher->matchDate();
            if (!empty($matchResult)) {
                //
                $field = Str::camel($matcher->getField());
                // Rule
                $template = '"%s%s" => "required|date|nullable",%s';
                // 替换
                $ruleString .= sprintf($template, $batchTemplate, $field, "\r\n");
                // Message
                $messageString .= "\"{$field}.required\" => \"缺少 {$field} 字段\",\r\n";
                $messageString .= "\"{$field}.date\" => \"字段 {$field} 日期格式错误\",\r\n";

                continue;
            }

            // 匹配不到类型
            $field = Str::camel($matcher->getField());
            // Rule
            $template   = '"%s%s" => "string|nullable",%s';
            $ruleString .= sprintf($template, $batchTemplate, $field, "\r\n");
            // Message
            $messageString .= "\"{$field}.string\" => \"字段 {$field} 格式错误\",\r\n";
        }

        return $ruleString;
    }

}
