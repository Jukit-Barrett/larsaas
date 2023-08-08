Route::group(
    [
        'middleware' => '{{AUTH_MIDDLEWARE}}',
    ],
    function (Router $router){
        // {{RNT}} ******** ******** ******** ********  ******** ******** ******** ********
        $router->apiResource('{{LOWER_ROUTE_NAME}}', \App\Http\Controllers\{{RNT}}Controller::class)->names(
            [
                'index'   => '{{RNT}}列表',
                'show'    => '{{RNT}}信息',
                'store'   => '{{RNT}}添加',
                'update'  => '{{RNT}}更新',
                'destroy' => '{{RNT}}删除',
            ]
        );

        $router->post('{{LOWER_ROUTE_NAME}}-ext/multi', [\App\Http\Controllers\{{RNT}}Controller::class, 'many'])->name('{{RNT}}批量获取');
});

//{{HERE}}
