<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\IndexActivityRequest;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Services\ActivityService;
use Mrzkit\LaravelCodeGenerator\TableDetail;
use Mrzkit\LaravelCodeGenerator\TableInformation;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ControllerTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ModelTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RepositoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RequestTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RouteTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\UnitTestTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateHandler;
use Mrzkit\LaravelCodeGenerator\TemplateUtil;
use Mrzkit\LaravelEloquentEnhance\Utils\ApiResponseEntity;

class ActivityController extends Controller
{
    use TemplateUtil;

    public function __construct(protected ActivityService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexActivityRequest $request)
    {
        $params = $request->validated();

        $list = $this->service->index($params);

        return ApiResponseEntity::success($list);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        $params = $request->validated();

        $result = $this->service->store($params);

        return ApiResponseEntity::success(["store" => $result]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        $object = $this->service->show($id);

        return ApiResponseEntity::success($object);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, int $id)
    {
        $params = $request->validated();

        $result = $this->service->update($id, $params);

        return ApiResponseEntity::success(["update" => $result]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $result = $this->service->destroy($id);

        return ApiResponseEntity::success(["destroy" => $result]);
    }

    public function restore(int $id)
    {
        $result = $this->service->restore($id);

        return ApiResponseEntity::success(["restore" => $result]);
    }

    public function codeGenerator()
    {
        $inputParams = [
            "tablePrefix" => env("DB_PREFIX"),
            "tableName" => "system_header",
//            "controls" => "SystemHeader",
        ];

        $tableInformation = new TableDetail($inputParams["tableName"], $inputParams["tablePrefix"]);

        $result = [];

        // Model
        $creator = new ModelTemplateCreator($tableInformation);

        $result["ModelTemplateCreator"] = $creator->handle();

        // Repository
        $creator = new RepositoryTemplateCreator($tableInformation);

        $result["RepositoryTemplateCreator"] = $creator->handle();

        // Service
        $creator = new ServiceTemplateCreator($tableInformation);

        $result["ServiceTemplateCreator"] = $creator->handle();

        // Request
        $creator = new RequestTemplateCreator($tableInformation);

        $result["RequestTemplateCreator"] = $creator->handle();

        // Controller
        $creator = new ControllerTemplateCreator($tableInformation);

        $result["ControllerTemplateCreator"] = $creator->handle();

        // Route
        $creator = new RouteTemplateCreator($tableInformation);

        $result["RouteTemplateCreator"] = $creator->handle();

        // UnitTest
        $creator = new UnitTestTemplateCreator($tableInformation);

        $result["UnitTestTemplateCreator"] = $creator->handle();


        return ApiResponseEntity::success($result);

    }

    public static function callCreator(array $params): array
    {
        if ($params["tableShard"]) {
            $inputParams = [
                "tableShard" => 1,
                "shardCount" => $params["shardCount"] >= 2 ? $params["shardCount"] : 2,
                "maxShardCount" => 64,
                "tablePrefix" => $params["tablePrefix"],
                "tableName" => $params["tableName"],
                "controls" => $params["controls"],
            ];
        } else {
            $inputParams = [
                "tableShard" => 0,
                "shardCount" => 0,
                "maxShardCount" => 0,
                "tablePrefix" => $params["tablePrefix"],
                "tableName" => $params["tableName"],
                "controls" => $params["controls"],
            ];
        }

        if (!static::validateControlName($inputParams["controls"])) {
            throw new \Exception("格式有误，参考格式: A.B 或 A.B.C ");
        }

        $tableInformation = new TableDetail($inputParams["tableName"], $inputParams["tablePrefix"]);

        $result = [];

        // Model
        $creator = new ModelTemplateCreator($tableInformation);

        $result["ModelTemplateCreator"] = $creator->handle();

        // Repository
        $creator = new RepositoryTemplateCreator($tableInformation);

        $result["RepositoryTemplateCreator"] = $creator->handle();

        // Service
        $creator = new ServiceTemplateCreator($inputParams["controls"], $tableInformation);

        $result["ServiceTemplateCreator"] = $creator->handle();

        // Request
        $creator = new RequestTemplateCreator($inputParams["controls"], $tableInformation);

        $result["RequestTemplateCreator"] = $creator->handle();

        // Controller
        $creator = new ControllerTemplateCreator($inputParams["controls"]);

        $result["ControllerTemplateCreator"] = $creator->handle();

        // Route
        $creator = new RouteTemplateCreator($inputParams["controls"]);

        $result["RouteTemplateCreator"] = $creator->handle();

        // UnitTest
        $creator = new UnitTestTemplateCreator($inputParams["controls"], $tableInformation);

        $result["UnitTestTemplateCreator"] = $creator->handle();

        return $result;
    }

}
