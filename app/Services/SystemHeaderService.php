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

class SystemHeaderService implements ControlServiceContract
{
    public function index(array $inputParams)
    {
        $params = [
            "page" => (int)($inputParams["page"] ?? 1),
            "perPage" => (int)($inputParams["perPage"] ?? 10),
            "sort" => (string)($inputParams["sort"] ?? "id"),
        ];

        $paginator = RepositoryFactory::getSystemHeaderRepository()->retrieve(new class($params) extends RetrieveQuery {

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
            "system_id" => (int) ($inputParams["systemId"] ?? 0),
"header_key" => (string) ($inputParams["headerKey"] ?? ""),
"header_val" => (string) ($inputParams["headerVal"] ?? ""),
"status" => (int) ($inputParams["status"] ?? 0),
"unique_column" => (int) ($inputParams["uniqueColumn"] ?? 0),
"sort" => (int) ($inputParams["sort"] ?? 0),

        ];

        return RepositoryFactory::getSystemHeaderRepository()->create($params);
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

        
                    if (isset($inputParams["systemId"])) {
                        $params["system_id"] = (int) ($inputParams["systemId"] ?? 0);
                    }
                
                    if (isset($inputParams["headerKey"])) {
                        $params["header_key"] = (string) ($inputParams["headerKey"] ?? "");
                    }
                
                    if (isset($inputParams["headerVal"])) {
                        $params["header_val"] = (string) ($inputParams["headerVal"] ?? "");
                    }
                
                    if (isset($inputParams["status"])) {
                        $params["status"] = (int) ($inputParams["status"] ?? 0);
                    }
                
                    if (isset($inputParams["uniqueColumn"])) {
                        $params["unique_column"] = (int) ($inputParams["uniqueColumn"] ?? 0);
                    }
                
                    if (isset($inputParams["sort"])) {
                        $params["sort"] = (int) ($inputParams["sort"] ?? 0);
                    }
                

        $result = false;

        if (!empty($params)) {
            $result = RepositoryFactory::getSystemHeaderRepository()->update($id, $params);
        }

        return $result;
    }

    public function destroy(int $id): bool
    {
        return RepositoryFactory::getSystemHeaderRepository()->delete($id);
    }

    /**
     * @desc 恢复数据
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return RepositoryFactory::getSystemHeaderRepository()->restore($id);
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
        return RepositoryFactory::getSystemHeaderRepository()->info($id, $fields, $relations, $before);
    }

}
