<?php

namespace Mrzkit\TemplateEngine;

use Mrzkit\TemplateEngine\Contracts\TemplateFileContract;
use Mrzkit\TemplateEngine\Contracts\TemplateFileSaveContract;

/**
 * 模板文件写入者，只负责写入文件
 */
class TemplateFileWriter extends TemplateFileAbstract implements TemplateFileContract, TemplateFileSaveContract
{
    /**
     * @var bool 是否强制写入
     */
    protected $force = false;

    public function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @desc 保存文件
     * @return bool
     */
    public function saveFile() : bool
    {
        $path = $this->getPath();

        $saveDir = dirname($path);

        if ( !file_exists($saveDir)) {
            if (!mkdir($saveDir, 0755, true) && !is_dir($saveDir)) {
                throw new \InvalidArgumentException('Make dir fail, Please check permissions.');
            }
        }

        // 不存在才写入
        if ( !file_exists($path) || $this->getForce()) {
            // 写入
            $writeResult = file_put_contents($path, $this->getContent());

            if ($writeResult !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @desc 设置强制写入
     * @param bool $force
     * @return $this
     */
    public function setForce(bool $force)
    {
        $this->force = $force;

        return $this;
    }

    /**
     * @desc 获取强制写入状态
     * @return bool
     */
    public function getForce() : bool
    {
        return $this->force;
    }
}
