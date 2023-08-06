# 快捷生成模型，数据库迁移，Flight 工厂类，数据库填充类，授权策略类，Flight 控制器和表单验证类...
php artisan make:model Flight --all


```php
php artisan make:model Activity --all
```

```shell

   INFO  Model [app/Models/Activity.php] created successfully.

   INFO  Factory [database/factories/ActivityFactory.php] created successfully.

   INFO  Migration [database/migrations/2023_08_06_153937_create_activities_table.php] created successfully.

   INFO  Seeder [database/seeders/ActivitySeeder.php] created successfully.

   INFO  Request [app/Http/Requests/StoreActivityRequest.php] created successfully.

   INFO  Request [app/Http/Requests/UpdateActivityRequest.php] created successfully.

   INFO  Controller [app/Http/Controllers/ActivityController.php] created successfully.

   INFO  Policy [app/Policies/ActivityPolicy.php] created successfully.
```
