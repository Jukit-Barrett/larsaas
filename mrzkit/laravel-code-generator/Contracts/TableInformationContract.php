<?php

namespace Mrzkit\LaravelCodeGenerator\Contracts;

interface TableInformationContract
{
    /**
     * @return string 表后缀
     */
    public function getTablePrefix(): string;

    /**
     * @return string 表名
     */
    public function getTableName(): string;

    /**
     * @return string 表全名
     */
    public function getTableFullName(): string;

    /**
     * @return array 表全列
     */
    public function getTableFullColumns(): array;

    /**
     * @return array 表字段
     */
    public function getTableFields(): array;

    /**
     * @desc
     * @return string 表后缀
     */
    public function getTableSuffix(): string;


    public function getRenderTableName(): string;

}
