<?php

namespace Tests\Feature;

use App\Http\Controllers\SystemHeaderController;
use Tests\Feature\BaseTest;

class SystemHeaderControllerTest extends BaseTest
{
    /**
     * 路由前缀
     */
    const PREFIX = "";

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::index()
     * @uri get:/system-header?page=1&perPage=20&orderType=-id
     */
    public function testIndex()
    {
        $query = [
            "page" => 1,
            "perPage" => 20,
            "orderType" => "+id",
        ];

        $uri = self::PREFIX . "/system-header" . '?' . http_build_query($query);

        $response = $this->get($uri, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::store()
     * @uri post:/system-header
     */
    public function testStore()
    {
        $data = [
            "systemId" => (int)1417687910103792989,
            "headerKey" => (string)"Hatter hurriedly left the court, without even waiting to put everything upon Bill! I wouldn\'t be.",
            "headerVal" => (string)"I know?\' said Alice, very earnestly. \'I\'ve had nothing yet,\' Alice replied in a low, hurried tone.",
            "status" => (int)181,
            "uniqueColumn" => (int)34,
            "sort" => (int)1979208939,

        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::show()
     * @uri get:/system-header/{id}
     */
    public function testShow()
    {
        $id = 1;

        $uri = self::PREFIX . "/system-header/{$id}";

        $response = $this->get($uri, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::update()
     * @uri put:/system-header/{id}
     */
    public function testUpdate()
    {
        $id = 2;

        $data = [
            "systemId" => (int)1417687910103792989,
            "headerKey" => (string)"Hatter hurriedly left the court, without even waiting to put everything upon Bill! I wouldn\'t be.",
            "headerVal" => (string)"I know?\' said Alice, very earnestly. \'I\'ve had nothing yet,\' Alice replied in a low, hurried tone.",
            "status" => (int)181,
            "uniqueColumn" => (int)34,
            "sort" => (int)1979208939,

        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header/{$id}";

        $response = $this->put($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::destroy()
     * @uri delete:/system-header/{id}
     */
    public function testDestroy()
    {
        $id = 2;

        $data = [];

        $uri = self::PREFIX . "/system-header/{$id}";

        $response = $this->delete($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::many()
     * @uri get:/system-header-ext/many
     */
    public function testMany()
    {
        $data = [
            "ids" => [1, 2, 3],
        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header-ext/many";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::batchDestroy()
     * @uri get:/system-header-ext/batch-destroy
     */
    public function testBatchDestroy()
    {
        $data = [
            "ids" => [1, 2, 3],
        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header-ext/batch-destroy";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::batchStore()
     * @uri get:/system-header-ext/batch-store
     */
    public function testBatchStore()
    {
        $data = [
            "batch" => [
                [
                    "systemId" => (int)1417687910103792989,
                    "headerKey" => (string)"Hatter hurriedly left the court, without even waiting to put everything upon Bill! I wouldn\'t be.",
                    "headerVal" => (string)"I know?\' said Alice, very earnestly. \'I\'ve had nothing yet,\' Alice replied in a low, hurried tone.",
                    "status" => (int)181,
                    "uniqueColumn" => (int)34,
                    "sort" => (int)1979208939,

                ],
            ],

        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header-ext/batch-store";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::batchUpdate()
     * @uri get:/system-header-ext/batch-update
     */
    public function testBatchUpdate()
    {
        $data = [
            "batch" => [
                [
                    "id" => 0,
                    "systemId" => (int)1417687910103792989,
                    "headerKey" => (string)"Hatter hurriedly left the court, without even waiting to put everything upon Bill! I wouldn\'t be.",
                    "headerVal" => (string)"I know?\' said Alice, very earnestly. \'I\'ve had nothing yet,\' Alice replied in a low, hurried tone.",
                    "status" => (int)181,
                    "uniqueColumn" => (int)34,
                    "sort" => (int)1979208939,

                ],
            ],

        ];

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header-ext/batch-update";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }

    /**
     * @desc SystemHeader
     * @see SystemHeaderController::batchStore()
     * @uri get:/system-header-ext/batch-store
     */
    public function testSeed()
    {
        $data = [
            "batch" => [],
        ];

        for ($i = 0; $i < 5; $i++) {
            $data["batch"][] = [
                "id" => (int)random_int(0, 9223372036854775807),
                "systemId" => (int)random_int(0, 9223372036854775807),
                "headerKey" => (string)addslashes($this->getFaker()->realTextBetween(5, 32)),
                "headerVal" => (string)addslashes($this->getFaker()->realTextBetween(5, 64)),
                "status" => (int)random_int(0, 255),
                "uniqueColumn" => (int)random_int(0, 255),
                "sort" => (int)random_int(0, 4294967295),
                "createdAt" => date('Y-m-d H:i:s'),
                "updatedAt" => date('Y-m-d H:i:s'),
                "deletedAt" => date('Y-m-d H:i:s'),

            ];
        }

        $dataJson = json_encode($data);

        $uri = self::PREFIX . "/system-header-ext/batch-store";

        $response = $this->post($uri, $data, ["Authorization" => $this->getToken(),]);

        $response->dump();

        $response->assertStatus(200);
    }
}
