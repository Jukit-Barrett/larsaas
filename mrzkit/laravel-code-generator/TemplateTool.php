<?php

namespace Mrzkit\LaravelCodeGenerator;

trait TemplateTool
{
    /**
     * @desc 验证控制器名称
     * @param string $controlName
     * @return bool
     */
    public static function validateControlName(string $controlName) : bool
    {
        $pattern = "/^[A-Za-z](\w+)?(\.?\w+)?/";

        if (preg_match($pattern, $controlName)) {
            return true;
        }

        return false;
    }

    /**
     * @desc
     * @param string $controlName
     * @return string
     */
    public static function processFirstControlName(string $controlName) : string
    {
        $numericalPosition = strpos($controlName, '.');

        if ($numericalPosition !== false) {
            $firstControlName = substr($controlName, 0, $numericalPosition);
        } else {
            $firstControlName = $controlName;
        }

        return $firstControlName;
    }

    /**
     * @desc 处理控制器名称
     * @param string $controlName
     * @return string
     */
    public static function processControlName(string $controlName) : string
    {
        $numericalPosition = strripos($controlName, '.');

        if ($numericalPosition !== false) {
            $controlName = substr($controlName, $numericalPosition + 1);
        }

        return $controlName;
    }

    /**
     * @desc 处理命名空间路径
     * @param string $controlName
     * @return string
     */
    public static function processNamespacePath(string $controlName) : string
    {
        $numericalPosition = strripos($controlName, '.');

        if ($numericalPosition !== false) {
            $namespacePath = substr($controlName, 0, $numericalPosition);
            $namespacePath = str_replace('.', '\\', $namespacePath);
        } else {
            $namespacePath = $controlName;
        }

        return $namespacePath;
    }

    /**
     * @desc 处理目录路径
     * @param string $controlName
     * @return string
     */
    public static function processDirectoryPath(string $controlName) : string
    {
        $namespacePath = static::processNamespacePath($controlName);

        $directoryPath = str_replace('\\', DIRECTORY_SEPARATOR, $namespacePath);

        $directoryPath = strlen($directoryPath) > 0 ? $directoryPath . DIRECTORY_SEPARATOR : $directoryPath;

        return $directoryPath;
    }
}
