<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    
    public function getAll()
    {
        return Task::orderBy('id','desc')->get();
    }
    
    public function addTask( Request $request )
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);
    
        Task::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
    }
    
    public function updateTask( Request $request )
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);
    
        Task::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
    }

    public function deleteTask(Request $request){  
        Task::where('id', $request->id)->delete();
    }

    
}
