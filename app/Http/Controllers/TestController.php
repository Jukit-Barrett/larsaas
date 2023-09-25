<?php

namespace App\Http\Controllers;

use Mrzkit\LaravelCodeGenerator\TableDetail;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ControllerTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ModelTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RepositoryFactoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RepositoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RequestTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RouteTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceFactoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\UnitTestTemplateCreator;
use Mrzkit\LaravelEloquentEnhance\Utils\ApiResponseEntity;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($request)
    {
        return ApiResponseEntity::success(['index' => __METHOD__]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        return ApiResponseEntity::success(['store' => __METHOD__]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return ApiResponseEntity::success(['show' => __METHOD__]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, int $id)
    {

        return ApiResponseEntity::success(["update" => __METHOD__]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

    }

    public function restore(int $id)
    {

    }

    public function codeGenerator()
    {
        $inputParams = [
            "tablePrefix" => env("DB_PREFIX"),
            "tableName"   => "system_header",
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

        // ServiceFactory
        $creator = new ServiceFactoryTemplateCreator($tableInformation);

        $result["ServiceFactoryTemplateCreator"] = $creator->handle();

        // RepositoryFactory
        $creator = new RepositoryFactoryTemplateCreator($tableInformation);

        $result["RepositoryFactoryTemplateCreator"] = $creator->handle();

        return ApiResponseEntity::success($result);

    }

}
