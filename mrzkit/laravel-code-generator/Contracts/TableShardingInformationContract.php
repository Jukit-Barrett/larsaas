<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

interface TableShardingInformationContract
{
    /**
     * @return bool 是否分表
     */
    public function isSharding(): bool;

    /**
     * @desc 最大分表数
     * @return int
     */
    public function getMaxShardingNumber(): int;

    /**
     * @desc 实际分表数
     * @return int
     */
    public function getRealShardingNumber(): int;

    /**
     * @desc 分表配置
     * @return array
     */
    public function getShardingConfig(): array;

    /**
     * @desc 分表后缀（数值）
     * @return array
     */
    public function getSuffixConfig(): array;


    /**
     * @desc 分表数值
     * @return int
     */
    public function getSuffixNumber() : int;

}
