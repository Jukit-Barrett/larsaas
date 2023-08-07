<?php

namespace Mrzkit\TemplateEngine\Contracts;

interface TemplateFileContract
{
    /**
     * @desc 设置文件路径
     * @param string $path
     * @return mixed
     */
    public function setPath(string $path);

    /**
     * @desc 获取文件路径
     * @return string
     */
    public function getPath() : string;

    /**
     * @desc 设置文件内容
     * @param string $content
     * @return mixed
     */
    public function setContent(string $content);

    /**
     * @desc 获取文件内容
     * @return string
     */
    public function getContent() : string;
}
