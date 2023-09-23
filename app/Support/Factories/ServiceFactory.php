<?php

namespace App\Support\Factories;

class ServiceFactory
{

    public static function getSystemHeaderService(): \App\Services\SystemHeaderService
{
    return app(\App\Services\SystemHeaderService::class);
}

//{{HERE}}


}
