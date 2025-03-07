<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        return Task::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
        ]);

        $task = Task::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        return response()->json($task, 201);
    }

    public function uploadImage(Request $request, Task $task)
    {
        // dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($task->image_path) {
            Storage::delete($task->image_path);
        }

        $path = $request->file('image')->store('task_images');
        $task->update(['image_path' => $path]);

        return response()->json(['message' => 'Image uploaded successfully']);
    }

    public function downloadImage(Task $task)
    {
        return Storage::download($task->image_path);
    }
}
