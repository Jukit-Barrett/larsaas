<?php

namespace Mrzkit\LaravelCodeGenerator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\Contracts\TableInformationContract;
use Mrzkit\LaravelCodeGenerator\Contracts\TableShardingInformationContract;

class TableDetail implements TableInformationContract, TableShardingInformationContract
{
    /**
     * @var string 表名
     */
    private $tableName;

    /**
     * @var string 表前缀
     */
    private $tablePrefix;

    /**
     * @var string 表后缀
     */
    private $tableSuffix;

    /**
     * @var string 表全名
     */
    private $tableFullName;

    /**
     * @var string 渲染的表名
     */
    private $renderTableName;

    /**
     * @var array 表列信息
     */
    private $tableFullColumns;

    /**
     * @var array 表字段
     */
    private $tableFields;

    /**
     * @var int 最大分表数
     */
    private $maxShardingNumber;

    /**
     * @var int 实际分表数
     */
    private $realShardingNumber;

    /**
     * @var int 分表后缀数值
     */
    private $suffixNumber;

    public function __construct(string $tableName, string $tablePrefix = '', int $maxShardingNumber = 0, int $realShardingNumber = 0)
    {
        // 表名
        $this->tableName = Str::snake($tableName);
        // 表前缀
        $this->tablePrefix = Str::snake($tablePrefix);
        // 全表名
        $this->tableFullName = $this->tablePrefix . $this->tableName;
        // 最大分表数
        $this->maxShardingNumber = $maxShardingNumber;
        // 实际分表数
        $this->realShardingNumber = $realShardingNumber;

        // 初始化表后缀
        $this->initTableSuffix();
        // 初始化分表后缀数值
        $this->initSuffixNumber();
        // 初始化渲染的表名
        $this->initRenderTableName();

        // 表初始化
        $this->initNormalTable();
        // 表字段全信息
        $this->initTableFullColumns();
        // 表字段
        $this->initTableFields();
    }

    /**
     * @desc
     */
    private function initNormalTable()
    {
        if (!Schema::hasTable($this->tableFullName)) {
            throw new \InvalidArgumentException("Not exists table: {$this->tableFullName}.");
        }
    }

    /**
     * @desc 表列信息初始化
     * @return $this
     */
    private function initTableFullColumns()
    {
        $sql = "SHOW FULL COLUMNS FROM `{$this->tableFullName}`";

        $resultSets = DB::select($sql);

        $tableFullColumns = [];

        foreach ($resultSets as $item) {
            $tableFullColumns[] = $item;
        }

        $this->tableFullColumns = $tableFullColumns;

        return $this;
    }

    // 全表列信息
    public function getTableFullColumns(): array
    {
        return $this->tableFullColumns;
    }

    /**
     * @desc 表字段初始化
     * @return $this
     */
    private function initTableFields()
    {
        $tableFields = [];

        foreach ($this->getTableFullColumns() as $item) {
            $tableFields[] = $item->Field;
        }

        $this->tableFields = $tableFields;

        return $this;
    }

    public function getTableFields(): array
    {
        return $this->tableFields;
    }

    // 是否分表
    public function isSharding(): bool
    {
        if (preg_match('/_(\d+)$/', $this->tableFullName, $matches)) {
            return true;
        }

        return false;
    }

    // 初始化表后缀
    private function initTableSuffix()
    {
        $tableSuffix = "";
        if ($this->isSharding()) {
            if (preg_match('/_(\d+)$/', $this->tableFullName, $matches)) {
                $tableSuffix = $matches[0];
            }
        }

        $this->tableSuffix = $tableSuffix;
    }


    // 表后缀
    public function getTableSuffix(): string
    {
        return $this->tableSuffix;
    }

    // 初始化分表后缀数值
    private function initSuffixNumber()
    {
        $suffixNumber = 0;
        if ($this->isSharding()) {
            if (preg_match('/_(\d+)$/', $this->tableFullName, $matches)) {
                $suffixNumber = (int)$matches[1];
            }
        }

        $this->suffixNumber = $suffixNumber;
    }

    // 分表后缀数值
    public function getSuffixNumber(): int
    {
        return $this->suffixNumber;
    }

    // 初始化渲染的表名
    private function initRenderTableName()
    {
        $tableName = $this->tableName;

        if ($this->isSharding()) {
            $suffix    = $this->getTableSuffix();
            $tableName = Str::replace($suffix, "", $tableName);
        }

        $this->renderTableName = Str::studly($tableName);
    }


    // 渲染的表名，如 UserTable
    public function getRenderTableName(): string
    {
        return $this->renderTableName;
    }

    /**
     * @desc 根据最大分表数和实际分表数，生成分表配置
     * @return array
     */
    public function getShardingConfig(): array
    {
        if (!$this->isSharding()) {
            return [];
        }

        // 最大分表数
        $maxShardingNumber = $this->getMaxShardingNumber();
        // 实际分表数
        $realShardingNumber = $this->getRealShardingNumber();

        if ($maxShardingNumber < 2 || $realShardingNumber < 2) {
            return [];
        }

        // 实际分表数不能大于最大分表数
        if ($realShardingNumber > $maxShardingNumber) {
            $maxShardingNumber = $realShardingNumber;
        }

        $shardCountConfig = [];

        for ($i = 0; $i < $realShardingNumber; $i++) {
            //
            $part = $maxShardingNumber / $realShardingNumber;

            $shardCountConfig[] = [
                'partition' => ($i + 1) * $part,
                'low' => $i * $part,
                'high' => ($i + 1) * $part - 1,
            ];
        }

        return $shardCountConfig;
    }

    /**
     * @desc
     * @return array
     */
    public function getSuffixConfig(): array
    {
        if (!$this->isSharding()) {
            return [];
        }

        // 最大分表数
        $maxShardingNumber = $this->getMaxShardingNumber();
        // 实际分表数
        $realShardingNumber = $this->getRealShardingNumber();

        if ($maxShardingNumber < 2 || $realShardingNumber < 2) {
            return [];
        }

        // 实际分表数不能大于最大分表数
        if ($realShardingNumber > $maxShardingNumber) {
            $maxShardingNumber = $realShardingNumber;
        }

        $suffixConfig = [];

        for ($i = 0; $i < $realShardingNumber; $i++) {
            $part = $maxShardingNumber / $realShardingNumber;

            $suffixConfig[] = ($i + 1) * $part;
        }

        return $suffixConfig;
    }


    // 最大分表数
    public function getMaxShardingNumber(): int
    {
        return $this->maxShardingNumber;
    }

    // 实际分表数
    public function getRealShardingNumber(): int
    {
        return $this->realShardingNumber;
    }

    // 表名
    public function getTableName(): string
    {
        return $this->tableName;
    }

    // 表前缀
    public function getTablePrefix(): string
    {
        return $this->tablePrefix;
    }

    // 全表名
    public function getTableFullName(): string
    {
        return $this->tableFullName;
    }

}
