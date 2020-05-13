<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Traits\ActingJWTUser;

class ExampleTest extends TestCase
{
    use RefreshDatabase, ActingJWTUser;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    // 测试发布
    public function testBasicTest()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        // 请求头带上 token
        $response = $this->JWTActingAs($this->user)->json('POST', '/api/v1/topics', $data);

        // 断言是啥 => 期望返回的数据格式？
        $assertData = [
            'category_id' => 1,
            'user_id' => $this->user->id,
            'title' => 'test title',
            'body' => clean('test body', 'user_topic_body'),
        ];

        // 期望返回的响应码
        $res = $response->assertStatus(201)->assertJsonFragment($assertData);
    }

    // 测试修改
    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();

        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];

        $response = $this->JWTActingAs($this->user)
            ->json('PATCH', '/api/v1/topics/' . $topic->id, $editData);

        $assertData = [
            'category_id' => 2,
            'user_id' => $this->user->id,
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
        ];

        $response->assertStatus(200)->assertJsonFragment($assertData);
    }

    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
    }

    // 测试查看
    public function testShowTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/v1/topics/' . $topic->id);

        $assertData = [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)->assertJsonFragment($assertData);
    }

    // 测试列表
    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/v1/topics');

        $response->assertStatus(200)->assertJsonStructure(['data', 'links', 'meta']);
    }

    // 测试删除
    public function testDeleteTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)->json('DELETE', '/api/v1/topics/' . $topic->id);
        $response->assertStatus(204);

        $response = $this->json('GET', '/api/v1/topics/' . $topic->id);
        $response->assertStatus(404);
    }
}


// (1) 会测试以 test 开头的方法
// (2) 定义请求
// 用 $response = $this->json($method, $uri, $data);
// (3) 执行，assertStatus($code) 断言，定义期望的响应码
// assertJsonFragment($assertData) 断言，定义期望的响应数据格式 (键及值)
// $response->assertStatus($code)->assertJsonFragment($assertData);
//                               ->assertJsonStructure($assertData); // 针对列表
