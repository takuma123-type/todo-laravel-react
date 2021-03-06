<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Facade\Ignition\Tabs\Tab;
use App\Http\Controllers\Request;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
    /**
     * タスク一覧
     *
     * @return Task[]\Illuminate\Database\Eloquest\Collection
     */
    
    public function index()
    {
        return Task::orderByDesc('id')->get();
    }

  
/**
 *  @param TaskRequest $request
 *  @return \Illuminate\Http\JsonResponse
 */
     public function store(StoreTaskRequest  $request, Task $task,)
    {
        $task = Task::create($request->all());

        return $task
            ? response()->json($task, 201)
            : response()->json([], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param \Request $request
     * @param  \App\Models\Task  $task
     * @return @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->title = $request->title;

        return $task->update()
            ? response()->json($task)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        return $task->delete()
            ? response()->json($task)
            : response()->json([], 500);
    }
}
