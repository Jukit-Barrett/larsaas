<?php

namespace App\Services;

use App\Support\Factories\RepositoryFactory;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mrzkit\LaravelEloquentEnhance\Contracts\ControlServiceContract;
use Mrzkit\LaravelEloquentEnhance\RetrieveQuery;
use Mrzkit\LaravelEloquentEnhance\Utils\Convert;
use Mrzkit\LaravelEloquentEnhance\Utils\RetrieveResponseEntity;

class ActivityService implements ControlServiceContract
{
    public function index(array $inputParams)
    {
        $params = [
            "page" => (int)($inputParams["page"] ?? 1),
            "perPage" => (int)($inputParams["perPage"] ?? 10),
            "sort" => (string)($inputParams["sort"] ?? "id"),
        ];

        $paginator = RepositoryFactory::getActivityRepository()->retrieve(new class($params) extends RetrieveQuery {

            private $params;

            public function __construct(array $params)
            {
                $this->params = $params;
            }

            public function sort(): string
            {
                return $this->params["sort"];
            }

            public function paging(): array
            {
                return [
                    "page" => $this->params["page"],
                    "perPage" => $this->params["perPage"],
                ];
            }

            public function before(): ?Closure
            {
                return function (Builder $builder) {

                };
            }

            public function after(): ?Closure
            {
                return function (Builder $builder) {
                };
            }
        });

        return RetrieveResponseEntity::retrieveIterator($paginator, function (Model $model) {

            $object = $model->toArray();

            return Convert::toArrayCamel($object);
        });
    }

    public function store(array $inputParams): bool
    {
        $params = [
            "system_id" => $inputParams["system_id"],
            "community_id" => $inputParams["community_id"],
            "name" => $inputParams["name"],
            "description" => $inputParams["description"],
        ];

        return RepositoryFactory::getActivityRepository()->create($params);
    }

    public function show(int $id): array
    {
        $object = $this->info($id, ['*']);

        if (empty($object)) {
            return [];
        }

        return Convert::toArrayCamel($object->toArray());
    }

    public function update(int $id, array $inputParams): bool
    {
        $param = [];

        if (isset($inputParams['system_id'])) {
            $param['system_id'] = $inputParams['system_id'];
        }

        if (isset($inputParams['name'])) {
            $param['name'] = $inputParams['name'];
        }

        $result = false;

        if (!empty($param)) {
            $result = RepositoryFactory::getActivityRepository()->update($id, $param);
        }

        return $result;
    }

    public function destroy(int $id): bool
    {
        return RepositoryFactory::getActivityRepository()->delete($id);
    }

    /**
     * @desc 恢复数据
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return RepositoryFactory::getActivityRepository()->restore($id);
    }

    /**
     * @desc 数据信息
     * @param int $id
     * @param array $fields
     * @param array $relations
     * @param Closure|null $before
     * @return Model|null
     */
    public function info(int $id, array $fields = ['id'], array $relations = [], Closure $before = null): ?Model
    {
        return RepositoryFactory::getActivityRepository()->info($id, $fields, $relations, $before);
    }

}
