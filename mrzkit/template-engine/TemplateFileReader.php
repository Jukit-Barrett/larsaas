<?php

namespace Mrzkit\TemplateEngine;

use InvalidArgumentException;
use Mrzkit\TemplateEngine\Contracts\TemplateFileContract;

/**
 * 模板文件读取者，只负责读取文件
 */
class TemplateFileReader extends TemplateFileAbstract implements TemplateFileContract
{
    public function __construct(string $path)
    {
        if ( !file_exists($path)) {
            throw new InvalidArgumentException('File not exists: ' . $path);
        }

        // 设置路径->设置内容
        $this->setPath($path)->setContent(file_get_contents($path));
    }
}
