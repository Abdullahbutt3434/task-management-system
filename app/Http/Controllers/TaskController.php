<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin')->except(['myTasks', 'taskOrderUpdate', 'taskTable']);
    }
    public function index()
    {
        $tasks = Task::with('user')->orderBy('id', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }
    public function store(StoreTask $request)
    {
        if (Task::where('user_id', $request->user_id)->where('priority', $request->priority)->first()) {
            return redirect()->back()->withInput($request->all())->with('error', 'Task with priority ' . $request->priority . ' for Selected User aleady exists.');
        }
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
            Log::info('error', $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
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
            if (Task::where('user_id', $request->user_id)->where('priority', $request->priority)->first()) {
                return redirect()->back()->withInput($request->all())->with('error', 'Task with priority ' . $request->priority . ' for Selected User aleady exists.');
            }
            DB::beginTransaction();
            $task = Task::where('id', $request->id)->first();
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
            Log::info('error', $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function destory(Request $request)
    {
        try {
            DB::beginTransaction();
            $task = Task::where('id', $request->id)->first();
            $task->delete();
            DB::commit();
            return redirect()->back()->with('success', "Task Delete Successfully");
        } catch (QueryException $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function myTasks()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('priority', 'asc')->get();
        return view('tasks.my-task', compact('tasks'));
    }

    public function taskOrderUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            $priorityArray = array();
            foreach ($request->data as $key => $value) {
                array_push($priorityArray, Task::find($value['taskId'])->priority);
            }
            sort($priorityArray);
            foreach ($request->data as $key => $value) {
                $task = Task::find($value['taskId']);
                $task->priority = $priorityArray[$key];
                $task->save();
            }
            DB::commit();
            return response()->json(array('success' => " Featured Products Order Updated Successfully"));
        } catch (QueryException $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
            return response()->json(array('error' => "Something Went Wrong"));
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('error', $e->getMessage());
            return response()->json(array('error' => "Something Went Wrong"));
        }
    }

    public function taskTable()
    {
        $html = "";
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('priority', 'asc')->get();
        foreach ($tasks as $key => $task) {
            $html = $html  . '<tr data-task-id="' . $task->id . '">
                        <th scope="row">' . $key + 1 . '</th>
                        <td>' . $task->user->name . '</td>
                        <td>' . $task->name . '</td>
                        <td class="priorityCol">' . $task->priority . '</td>
                        <td>' . \Carbon\Carbon::parse($task->start)->toDayDateTimeString() . '</td>
                        <td>' . \Carbon\Carbon::parse($task->end)->toDayDateTimeString() . '</td>
                      
                    </tr>';
        }
        return response()->json(array('html' => $html));
    }
}
