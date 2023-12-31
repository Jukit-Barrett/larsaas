<?php

namespace Mrzkit\LaravelCodeGenerator;

use Mrzkit\LaravelCodeGenerator\TemplateCreators\ControllerTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RepositoryTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RequestTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\RouteTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\ServiceTemplateCreator;
use Mrzkit\LaravelCodeGenerator\TemplateCreators\UnitTestTemplateCreator;

class Tester
{
    use TemplateUtil;

    public static function testRunner()
    {
        $params1 = [
            "tableShard" => 1,
            "shardCount" => 2,
            "maxShardCount" => 64,
            "tablePrefix" => env('DB_PREFIX', ""),
            "tableName" => "renewal_payments",
            "controls" => "CpcSystem.RenewalPayments",
        ];

        $params2 = [
            "tableShard" => 0,
            "shardCount" => 0,
            "maxShardCount" => 0,
            "tablePrefix" => env('DB_PREFIX', ""),
            "tableName" => "tags",
            "controls" => "CpcSystem.Tag",
        ];

        dump(static::callCreator($params2));
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
