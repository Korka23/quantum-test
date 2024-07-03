<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resource\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TaskController extends Controller
{
    public function index(IndexTaskRequest $request)
    {
        $validated = $request->validated();
        return TaskResource::collection(Task::query()
            ->when(isset($validated['status']), function ($query) use($validated){
                $query->where('status', $validated['status']);
            })
            ->when(isset($validated['created_at']), function ($query) use($validated){
                $query->where('created_at', $validated['created_at']);
            })
            ->where('user_id', $request->user()->id)
            ->paginate($validated['page_size'] ?? 10));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return TaskResource::make($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        return TaskResource::make(Task::query()->create(array_merge($validated, ['user_id' => $request->user()->id])));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validated();
        return TaskResource::make($task->update(array_merge($validated)));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        return $task->delete();
    }
}