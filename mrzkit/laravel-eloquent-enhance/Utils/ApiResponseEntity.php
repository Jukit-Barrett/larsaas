<?php

namespace Mrzkit\LaravelEloquentEnhance\Utils;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * API 响应结构体
 */
class ApiResponseEntity
{
    /**
     * @desc 成功返回
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public static function success(array $data = [], string $msg = "success", int $code = Response::HTTP_OK): JsonResponse
    {
        return static::jsonResponse($data, $msg, $code);
    }

    /**
     * @desc 失败返回
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public static function failure(array $data = [], string $msg = "failure", int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return static::jsonResponse($data, $msg, $code);
    }

    /**
     * @desc Json响应
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public static function jsonResponse(array $data = [], string $msg = '', int $code = 0): JsonResponse
    {
        $payload = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return new JsonResponse($payload, $code);
    }

}
