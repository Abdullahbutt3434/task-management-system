<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->orderBy('updated_at', 'desc')->paginate(5);
        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }
    public function store(StoreTask $request)
    {
        try {
            DB::beginTransaction();
            $task = new Task();
            $task->name = $request->name;
            $task->priority = $request->priority;
            $task->start = $request->start;
            $task->end = $request->end;
            $task->user_id = $request->user_id;
            $task->save();

            DB::commit();
            return redirect()->route('tasks.list')->with('success', 'Task Added Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function edit($id)
    {
        if (!Task::with('user')->where('id', $id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        $task = Task::with('user')->where('id', $id)->first();
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $task = Task::find($request->id)->first();
            $task->name = $request->name;
            $task->priority = $request->priority;
            $task->start = $request->start;
            $task->end = $request->end;
            $task->user_id = $request->user_id;
            $task->save();
            DB::commit();
            return redirect()->route('tasks.list')->with('success', 'Task Updated Successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function destory(Request $request)
    {
        try {
            DB::beginTransaction();
            $task = Task::find($request->id)->first();
            $task->delete();

            DB::commit();
            return redirect()->back()->with('success', "Task Delete Successfully");
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function myTasks()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->paginate(5);
        return view('tasks.my-task', compact('tasks'));
    }
}
