<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function saveTask(Request $request)
    {
        $taskName = $request->input('taskName');
        $note = $request->input('note');
        $dueDate = $request->input('dueDate');
        $isChangeDate = $request->input('isChangeDate');

        DB::table('tasks')->insert([
            'NAME' => $taskName,
            'NOTE' => $note,
            'DUEDATE' => $isChangeDate ? $dueDate : null,
            'ISCOMPLETE' => false
        ]);

        Log::info('Task saved successfully');

        return response()->json(['message' => 'Task saved successfully'], 200);
    }

    public function getTasks(){
        $tasks = DB::table('tasks')->get();
        return response()->json($tasks);
    }

    public function updateTask(Request $request){
        $taskID = $request->input('taskID');
        $taskName = $request->input('taskName');
        $note = $request->input('note');
        $dueDate = $request->input('dueDate');

        DB::table('tasks')->where('TASK_ID', $taskID)->update([
            'NAME' => $taskName,
            'NOTE' => $note,
            'DUEDATE' => $dueDate
        ]);

        Log::info('Task updated successfully', ['taskID' => $taskID]);

        return response()->json(['message' => 'Task updated successfully'], 200);
    }

    public function updateStateTask(Request $request){
        $taskID = $request->input('taskID');
        $isComplete = $request->input('isComplete');

        DB::table('tasks')->where('TASK_ID', $taskID)->update([
            'ISCOMPLETE' => $isComplete
        ]);

        Log::info('Task state updated successfully', ['taskID' => $taskID]);

        return response()->json(['message' => 'Task state updated successfully'], 200);
    }

    public function deleteTask(Request $request){
        $taskID = $request->input('taskID');

        DB::table('tasks')->where('TASK_ID', $taskID)->delete();

        Log::info('Task deleted successfully', ['taskID' => $taskID]);

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
