<?php

namespace Mrzkit\LaravelEloquentEnhance\Utils;

use Illuminate\Support\Str;

class Convert
{
    /**
     * @desc 将 KEY 转换为驼峰命名
     * @param array $row
     * @return array
     */
    public static function toArrayCamel(array $row): array
    {
        $camelRow = [];

        foreach ($row as $key => $value) {
            $camelRow[Str::camel($key)] = $value;
        }

        return $camelRow;
    }

    /**
     * @desc 将 KEY 转换为下划线命名
     * @param array $row
     * @return array
     */
    public static function toArraySnake(array $row): array
    {
        $snakeRow = [];

        foreach ($row as $key => $value) {
            $snakeRow[Str::snake($key)] = $value;
        }

        return $snakeRow;
    }

}
