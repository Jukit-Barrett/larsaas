<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class BaseTest extends TestCase
{
    public function getToken(): string
    {
        $data = [
            "captcha" => (string)"captcha",
            "key" => (string)"key",
            "mobile" => (string)env("UNIT_TEST_USERNAME", ""),
            "password" => (string)env("UNIT_TEST_PASSWORD", ""),
        ];

        if (empty($data["mobile"]) || empty($data["password"])) {
            throw new \Exception("请配置环境变量: UNIT_TEST_USERNAME 和 UNIT_TEST_PASSWORD");
        }

        $cacheKey = "UnitTest:" . $data["mobile"];

        $token = Cache::remember($cacheKey, 46400, function () use ($data) {
            //
            $uri = "/us/auth/login-mobile";

            $response = $this->post($uri, $data);

            $response->assertStatus(200);

            return $response->json("data.accessToken");
        });

        return $token;
    }

    public function getFaker(): \Faker\Generator
    {
        return app(\Faker\Generator::class);
    }
}
