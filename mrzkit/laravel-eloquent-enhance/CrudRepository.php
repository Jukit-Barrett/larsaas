<?php

namespace Mrzkit\LaravelEloquentEnhance;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Mrzkit\LaravelEloquentEnhance\Contracts\ModelContract;
use Mrzkit\LaravelEloquentEnhance\Contracts\RepositoryContract;
use Mrzkit\LaravelEloquentEnhance\Contracts\ResolverContract;
use Mrzkit\LaravelEloquentEnhance\Contracts\RetrieveQueryContract;
use Mrzkit\LaravelEloquentEnhance\Contracts\TrashContract;
use Mrzkit\LaravelEloquentEnhance\Exceptions\CrudException;

abstract class CrudRepository implements ModelContract, RepositoryContract, ResolverContract, TrashContract
{
    use ResolverTrait;

    /**
     * @var Model 模型
     */
    protected $model;

    /**
     * @desc 设置模型
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @desc 获取模型
     * @return EnhanceModel
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @desc 获取克隆模型
     * @return EnhanceModel
     */
    public function getCloneModel()
    {
        return clone $this->getModel();
    }

    /**
     * @desc 创建
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $model = $this->getCloneModel();

        return $model->fill($data)->save();
    }

    /**
     * @desc 检索
     * @param RetrieveQueryContract $retrieveContract
     * @return LengthAwarePaginator
     */
    public function retrieve(RetrieveQueryContract $retrieveContract): LengthAwarePaginator
    {
        $columns = $retrieveContract->columns();

        $paging = $retrieveContract->paging();

        $conf = [
            "perPage" => (int)($paging["perPage"] ?? 20),
            "columns" => empty($columns) ? $columns : ["*"],
            "pageName" => (string)($paging["pageName"] ?? "page"),
            "page" => (int)($paging["page"] ?? 1),
        ];

        $query = $this->getModel()->newQuery();

        // 查询前处理
        $before = $retrieveContract->before();
        if (!is_null($before)) {
            $before($query);
        }

        // 关联解析器
        $relations = $retrieveContract->relations();
        if (!empty($relations)) {
            $query = $this->relationResolver($query, $relations);
        }

        // 关联排序解析器
        $sortKey = $retrieveContract->sort();
        if (!empty($sortKey)) {
            $query = $this->sortResolver($query, $sortKey);
        }

        // 分页查询
        $lengthAwarePaginator = $query->select($columns)->paginate($conf["perPage"], ["*"], $conf["pageName"], $conf["page"]);

        $after = $retrieveContract->after();
        if (!is_null($after)) {
            $after($query);
        }

        return $lengthAwarePaginator;
    }

    /**
     * @desc 更新
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        $model = $this->getCloneModel();

        $primaryName = $model->getKeyName();

        $object = $model->newQuery()->select([$primaryName])->where($primaryName, $id)->first();

        if (is_null($object)) {
            return false;
        }

        return $object->update($attributes);
    }

    /**
     * @desc 删除
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $object = $this->info($id);

        if (is_null($object)) {
            return false;
        }

        return $object->delete();
    }

    /**
     * @desc 数据信息
     * @param int $id
     * @param array $fields
     * @param array $relations
     * @param Closure|null $before
     * @return Model|null
     */
    public function info(int $id, array $fields = ["id"], array $relations = [], Closure $before = null): ?Model
    {
        $query = $this->getModel()->newQuery();

        if (!is_null($before)) {
            $before($query);
        }

        // 关联解析器
        if (!empty($relations)) {
            $query = $this->relationResolver($query, $relations);
        }

        $row = $query->select($fields)->where($this->getModel()->getKeyName(), $id)->first();

        return $row;
    }

    /**
     * @desc 多条数据信息
     * @param array $ids
     * @param array $fields
     * @param array $relations
     * @param Closure|null $before
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function multi(array $ids, array $fields = ['id'], array $relations = [], Closure $before = null)
    {
        $query = $this->getModel()->newQuery();

        if (!is_null($before)) {
            $before($query);
        }

        if (!empty($relations)) {
            $query = $this->relationResolver($query, $relations);
        }

        $rows = $query->select($fields)->whereIn($this->getModel()->getKeyName(), $ids)->get();

        return $rows;
    }

    /**
     * @desc 恢复软删除的数据
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $query = $this->getModel()->newQuery();

        $keyName = $this->getModel()->getKeyName();

        $row = $query->select([$keyName])->where($keyName, $id)->withTrashed()->first();

        if (is_null($row)) {
            return false;
        }

        return $row->restore();
    }

}
