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

class {{RNT}}Service implements ControlServiceContract
{
    public function index(array $inputParams)
    {
        $params = [
            "page" => (int)($inputParams["page"] ?? 1),
            "perPage" => (int)($inputParams["perPage"] ?? 10),
            "sort" => (string)($inputParams["sort"] ?? "id"),
        ];

        $paginator = RepositoryFactory::get{{RNT}}Repository()->retrieve(new class($params) extends RetrieveQuery {

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
            {{SERVICE_STORE_TPL}}
        ];

        return RepositoryFactory::get{{RNT}}Repository()->create($params);
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
        $params = [];

        {{SERVICE_UPDATE_TPL}}

        $result = false;

        if (!empty($params)) {
            $result = RepositoryFactory::get{{RNT}}Repository()->update($id, $params);
        }

        return $result;
    }

    public function destroy(int $id): bool
    {
        return RepositoryFactory::get{{RNT}}Repository()->delete($id);
    }

    /**
     * @desc 恢复数据
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return RepositoryFactory::get{{RNT}}Repository()->restore($id);
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
        return RepositoryFactory::get{{RNT}}Repository()->info($id, $fields, $relations, $before);
    }

}
