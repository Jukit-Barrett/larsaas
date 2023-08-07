<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activity\IndexActivityRequest;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Services\ActivityService;
use Illuminate\Support\Str;
use Mrzkit\LaravelCodeGenerator\TableInformation;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ControllerTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateHandler;
use Mrzkit\LaravelEloquentEnhance\Utils\ApiResponseEntity;

class ActivityController extends Controller
{
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
            "tablePrefix" => "ch_",
            "tableName" => "system_header",
//            "controls" => "SystemHeader",
        ];

        $tableInformation = new TableInformation($inputParams["tableName"], $inputParams["tablePrefix"]);

        $templateHandler = new TemplateHandler();

        $controlName = Str::studly($tableInformation->getTableName());

        // Controller
        $creator = new ControllerTemplateCreator($controlName, $templateHandler);

        $result["ControllerTemplateCreator"] = $creator->handle();


        // Service
        $creator = new ServiceTemplateCreator($controlName, $templateHandler, $tableInformation);

        $result["ServiceTemplateCreator"] = $creator->handle();

        return ApiResponseEntity::success($result);

    }
}
