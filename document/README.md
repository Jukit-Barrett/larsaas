# 快捷生成模型，数据库迁移，Flight 工厂类，数据库填充类，授权策略类，Flight 控制器和表单验证类...
php artisan make:model Flight --all

```php
php artisan make:model Activity --all
```

```shell

   INFO  Model [app/Models/Activity.php] created successfully.

   INFO  Migration [database/migrations/2023_08_06_153937_create_activities_table.php] created successfully.

   INFO  Seeder [database/seeders/ActivitySeeder.php] created successfully.

   INFO  Request [app/Http/Requests/StoreActivityRequest.php] created successfully.

   INFO  Request [app/Http/Requests/UpdateActivityRequest.php] created successfully.

   INFO  Controller [app/Http/Controllers/ActivityController.php] created successfully.


   INFO  Factory [database/factories/ActivityFactory.php] created successfully.
   INFO  Policy [app/Policies/ActivityPolicy.php] created successfully.
```


## Laravel 初始化指南

### ForceAcceptJson - 以 JSON 结构返回

1. 创建中间件，内容如下

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceAcceptJson
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

    return $next($request);
    }
}

```

2. 添加全局中间件

文件: app/Http/Kernel.php

```php

protected $middleware = [
    ...
    // Json 中间件，无论正确、错误、异常，都返回JSON格式
    \Mrzkit\LaravelEloquentEnhance\Middleware\ForceAcceptJson::class
];
```

## 添加服务提供者



```php
<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class LazyServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        foreach ($this->provides() as $provide) {
            $this->app->singleton($provide);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * 获取服务提供者的服务
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        //
        return [UserService::class];
    }
}

```

```php
config/app.php

'providers' => ServiceProvider::defaultProviders()->merge([
        ...
        App\Providers\LazyServiceProvider::class,
    ])->toArray(),
```
