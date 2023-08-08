<?php

namespace Mrzkit\LaravelCodeGenerator;

use Mrzkit\LaravelCodeGenerator\Contracts\DataTypeMatchContract;

class DataTypeMatcher implements DataTypeMatchContract
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $comment;

    public function __construct(string $field, string $type, string $comment)
    {
        $this->field   = $field;
        $this->type    = $type;
        $this->comment = $comment;
    }

    /**
     * @return String
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return String
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return String
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @desc 匹配整型
     * @return array
     */
    public function matchInt(): array
    {
        $type = strtolower($this->getType());

        if (str_contains($type, "unsigned")) {
            $isSigned = true;
        } else {
            $isSigned = false;
        }

        // 方式1: preg_match('/^int/', $type)
        // 方式2: 0 === strpos($type, "int")
        // 方式3: str_starts_with($type, "int")

        if (str_starts_with($type, "int")) {
            //
            $result["type"] = "integer";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = 4294967295;
            } else {
                // 有符号
                $result["min"] = -((4294967295 >> 1) + 1);
                $result["max"] = (4294967295 >> 1);
            }
        } else if (str_starts_with($type, "tinyint")) {
            //
            $result["type"] = "integer";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = 255;
            } else {
                // 有符号
                $result["min"] = -128;
                $result["max"] = 127;
            }
        } else if (str_starts_with($type, "smallint")) {
            //
            $result["type"] = "integer";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = 65536;
            } else {
                // 有符号
                $result["min"] = -32768;
                $result["max"] = 32767;
            }
        } else if (str_starts_with($type, "mediumint")) {
            //
            $result["type"] = "integer";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = 16777215;
            } else {
                // 有符号
                $result["min"] = -8388608;
                $result["max"] = 8388607;
            }
        } else if (str_starts_with($type, "bigint")) {
            //
            $result["type"] = "integer";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = PHP_INT_MAX;
            } else {
                // 有符号
                $result["min"] = -(PHP_INT_MAX + 1);
                $result["max"] = PHP_INT_MAX;
            }
        } else {
            //
            $result = [];
        }

        return $result;
    }

    /**
     * @desc 匹配字符串类型
     * @return array
     */
    public function matchString(): array
    {
        $type = strtolower($this->getType());

        if (0 === strpos($type, "char")) {
            //
            $result["type"] = "string";
            if (preg_match('/\((\d+)\)/', $type, $matches)) {
                $result["min"] = 0;
                $result["max"] = $matches[1];
            } else {
                $result["min"] = 0;
                $result["max"] = 255;
            }
        } else if (str_starts_with($type, "varchar")) {
            //
            $result["type"] = "string";
            if (preg_match('/\((\d+)\)/', $type, $matches)) {
                $result["min"] = 0;
                $result["max"] = $matches[1];
            } else {
                $result["min"] = 0;
                $result["max"] = 65535;
            }
        } else if (str_starts_with($type, "tinytext")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 255;
        } else if (str_starts_with($type, "text")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 65535;
        } else if (str_starts_with($type, "mediumtext")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 1677215;
        } else if (str_starts_with($type, "longtext")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 4294967295;
        } else if (str_starts_with($type, "tinyblob")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 255;
        } else if (str_starts_with($type, "blob")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 65535;
        } else if (str_starts_with($type, "mediumblob")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 1677215;
        } else if (str_starts_with($type, "longblob")) {
            $result["type"] = "string";
            $result["min"]  = 0;
            $result["max"]  = 4294967295;
        } else {
            //
            $result = [];
        }

        return $result;
    }

    /**
     * @desc 匹配浮点型
     * @return array
     */
    public function matchFloat(): array
    {
        $type = strtolower($this->getType());

        if (str_contains($type, "unsigned")) {
            $isSigned = true;
        } else {
            $isSigned = false;
        }

        if (str_starts_with($type, "decimal")) {
            //
            $result["type"] = "double";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = PHP_FLOAT_MAX;
            } else {
                // 有符号
                $result["min"] = PHP_FLOAT_MIN;
                $result["max"] = PHP_FLOAT_MAX;
            }
        } else if (str_starts_with($type, "double")) {
            //
            $result["type"] = "double";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = PHP_FLOAT_MAX;
            } else {
                // 有符号
                $result["min"] = PHP_FLOAT_MIN;
                $result["max"] = PHP_FLOAT_MAX;
            }
        } else if (str_starts_with($type, "float")) {
            //
            $result["type"] = "double";
            if ($isSigned) {
                // 无符号
                $result["min"] = 0;
                $result["max"] = PHP_FLOAT_MAX;
            } else {
                // 有符号
                $result["min"] = PHP_FLOAT_MIN;
                $result["max"] = PHP_FLOAT_MAX;
            }
        } else {
            //
            $result = [];
        }

        return $result;
    }

    /**
     * @desc 匹配日期类型
     * @return array
     */
    public function matchDate(): array
    {
        $type = strtolower($this->getType());

        if (str_starts_with($type, "date")) {
            //
            $result["type"] = "string";
            $result["min"]  = "";
            $result["max"]  = "";
        } else if (str_starts_with($type, "time")) {
            //
            $result["type"] = "string";
            $result["min"]  = "";
            $result["max"]  = "";
        } else if (str_starts_with($type, "year")) {
            //
            $result["type"] = "string";
            $result["min"]  = "";
            $result["max"]  = "";
        } else if (str_starts_with($type, "datetime")) {
            //
            $result["type"] = "string";
            $result["min"]  = "";
            $result["max"]  = "";
        } else if (str_starts_with($type, "timestamp")) {
            //
            $result["type"] = "string";
            $result["min"]  = "";
            $result["max"]  = "";
        } else {
            //
            $result = [];
        }

        return $result;
    }
}
