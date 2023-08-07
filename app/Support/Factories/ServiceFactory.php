<?php

namespace App\Support\Factories;

use App\Services\ActivityService;

class ServiceFactory
{
    public static function getActivityService(): ActivityService
    {
        return app(ActivityService::class);
    }
}
