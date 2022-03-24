<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Http\Controllers\TaskController;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function 一覧を取得できる()
    {
        $tasks = Task::factory()->count(10)->create();

        $response = $this->getJson('api/tasks');

        $response
            ->assertOK()
            ->assertJsonCount($tasks->count());
    }

    /**
     *  @test
     */
    public function 登録することができる()
    {
        $data = [
            'title' => 'テスト投稿'
        ];

        $response = $this->postJson('api/tasks', $data);

        $response
            ->assertCreated()
            ->assertJsonFragment($data);
    }

    /**
     *  @test
     */
    public function 更新することができる()
    {
        $task = Task::factory()->create();

        $task->title = '書き換え';

        $response = $this->patchJson('api/tasks{$task->id}', $task->toArray());

        $response
            ->assertOK()
            ->assertJsonFragment($task->toArray());
    }

    /**
     *  @test
     */
    public function 削除することができる()
    {
        $task = Task::factory()->count(10)->create();
        
        $response = $this->deleteJson('api/tasks/1');

        $response
            ->assertOK()
            ->assertJsonFragment($task->toArray());
    }


    /**
     *  @test
     */
    public function タイトルは255文字の場合は登録できない()
    {
        $data = [
            'title' => str_repeat('あ', 256)
        ];

        $response = $this->postJson('api/tasks', $data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => 'タイトルは、２５５文字以下にしてください'
            ]);
    }
}