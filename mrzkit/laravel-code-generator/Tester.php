<?php

namespace Mrzkit\LaravelCodeGenerator;

use Mrzkit\LaravelCodeGenerator\TemplateCreators\ComponentCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ControllerTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RepositoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RequestTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RouteTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\UnitTestTemplateCreator;

class Tester
{
    use TemplateTool;

    public static function testRunner()
    {
        $params1 = [
            "tableShard"    => 1,
            "shardCount"    => 2,
            "maxShardCount" => 64,
            "tablePrefix"   => env('DB_PREFIX', ""),
            "tableName"     => "renewal_payments",
            "controls"      => "CpcSystem.RenewalPayments",
        ];

        $params2 = [
            "tableShard"    => 0,
            "shardCount"    => 0,
            "maxShardCount" => 0,
            "tablePrefix"   => env('DB_PREFIX', ""),
            "tableName"     => "tags",
            "controls"      => "CpcSystem.Tag",
        ];

        dump(static::callCreator($params2));
    }

    public static function callCreator(array $params) : array
    {
        if ($params["tableShard"]) {
            $inputParams = [
                "tableShard"    => 1,
                "shardCount"    => $params["shardCount"] >= 2 ? $params["shardCount"] : 2,
                "maxShardCount" => 64,
                "tablePrefix"   => $params["tablePrefix"],
                "tableName"     => $params["tableName"],
                "controls"      => $params["controls"],
            ];
        } else {
            $inputParams = [
                "tableShard"    => 0,
                "shardCount"    => 0,
                "maxShardCount" => 0,
                "tablePrefix"   => $params["tablePrefix"],
                "tableName"     => $params["tableName"],
                "controls"      => $params["controls"],
            ];
        }

        if ( !static::validateControlName($inputParams["controls"])) {
            throw new \Exception("格式有误，参考格式: A.B 或 A.B.C ");
        }

        $tableInformation = new TableInformation($inputParams["tableName"], $inputParams["tablePrefix"], $inputParams["tableShard"], $inputParams["shardCount"], $inputParams["maxShardCount"]);

        $templateHandler = new TemplateHandler();

        $result = [];

        // Repository
        $creator = new RepositoryTemplateCreator($templateHandler, $tableInformation);

        $result["RepositoryTemplateCreator"] = $creator->handle();

        // Service
        $creator = new ServiceTemplateCreator($inputParams["controls"], $templateHandler, $tableInformation);

        $result["ServiceTemplateCreator"] = $creator->handle();

        // Request
        $creator = new RequestTemplateCreator($inputParams["controls"], $templateHandler, $tableInformation);

        $result["RequestTemplateCreator"] = $creator->handle();

        // Controller
        $creator = new ControllerTemplateCreator($inputParams["controls"], $templateHandler);

        $result["ControllerTemplateCreator"] = $creator->handle();

        // Route
        $creator = new RouteTemplateCreator($inputParams["controls"], $templateHandler);

        $result["RouteTemplateCreator"] = $creator->handle();

        // UnitTest
        $creator = new UnitTestTemplateCreator($inputParams["controls"], $templateHandler, $tableInformation);

        $result["UnitTestTemplateCreator"] = $creator->handle();

        return $result;
    }

    public static function callSimpleCreator(array $params) : array
    {
        if ($params["tableShard"]) {
            $inputParams = [
                "tableShard"    => 1,
                "shardCount"    => $params["shardCount"] >= 2 ? $params["shardCount"] : 2,
                "maxShardCount" => 64,
                "tablePrefix"   => $params["tablePrefix"],
                "tableName"     => $params["tableName"],
                "controls"      => $params["controls"],
            ];
        } else {
            $inputParams = [
                "tableShard"    => 0,
                "shardCount"    => 0,
                "maxShardCount" => 0,
                "tablePrefix"   => $params["tablePrefix"],
                "tableName"     => $params["tableName"],
                "controls"      => $params["controls"],
            ];
        }

        if ( !static::validateControlName($inputParams["controls"])) {
            throw new \Exception("格式有误，参考格式: A.B 或 A.B.C ");
        }

        $tableInformation = new TableInformation($inputParams["tableName"], $inputParams["tablePrefix"], $inputParams["tableShard"], $inputParams["shardCount"], $inputParams["maxShardCount"]);

        $templateHandler = new TemplateHandler();

        $result = [];

        // Repository
        $creator = new RepositoryTemplateCreator($templateHandler, $tableInformation);

        $result["RepositoryTemplateCreator"] = $creator->handle();

        // Service
        $creator = new ServiceTemplateCreator($inputParams["controls"], $templateHandler, $tableInformation);

        $result["ServiceTemplateCreator"] = $creator->handle();

        return $result;
    }

    public static function callComponentCreator(string $componentName) : array
    {
        $templateHandler = new TemplateHandler();

        $result = [];

        // Component
        $creator = new ComponentCreator($componentName, $templateHandler);

        $result["ComponentCreator"] = $creator->handle();

        return $result;
    }

}