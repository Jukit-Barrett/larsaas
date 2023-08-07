<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemHeader\IndexSystemHeaderRequest;
use App\Http\Requests\SystemHeader\StoreSystemHeaderRequest;
use App\Http\Requests\SystemHeader\UpdateSystemHeaderRequest;
use App\Services\SystemHeaderService;
use Mrzkit\LaravelEloquentEnhance\Utils\ApiResponseEntity;

class SystemHeaderController extends Controller
{
    public function __construct(protected SystemHeaderService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexSystemHeaderRequest $request)
    {
        $params = $request->validated();

        $list = $this->service->index($params);

        return ApiResponseEntity::success($list);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSystemHeaderRequest $request)
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
    public function update(UpdateSystemHeaderRequest $request, int $id)
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
}
