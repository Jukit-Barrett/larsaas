<?php

namespace Mrzkit\TemplateEngine;

use InvalidArgumentException;

abstract class TemplateFileAbstract
{
    /**
     * @var string 文件路径
     */
    protected $path = '';

    /**
     * @var string 文件内容
     */
    protected $content = '';

    /**
     * @desc 设置文件路径
     * @param string $path
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @desc 获取文件路径
     * @return string
     */
    public function getPath() : string
    {
        if (empty($this->path)) {
            throw new InvalidArgumentException('Path is empty.');
        }

        return $this->path;
    }

    /**
     * @desc 设置文件内容
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @desc 获取文件内容
     * @return string
     */
    public function getContent() : string
    {
        if (empty($this->content)) {
            throw new InvalidArgumentException('Content is empty.');
        }

        return $this->content;
    }
}
