<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\News;
use App\Task;
use App\User;
use App\Message;
use GrabzItClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $user_id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user_id = Auth::id();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function task()
    {

        $tasks = User::find($this->user_id)
            ->tasks()
            ->orderBy('created_at', 'desc')
            ->get();

        $tasksCount = count($tasks);

        return view('task', [
            'tasks' => $tasks,
            'tasksCount' => $tasksCount
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|max:255',
        ]);

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        $lastid = $task->id;

        $usertask = User::find($this->user_id);
        $usertask->tasks()->attach($lastid);

        Session::flash('alert-success', 'New task was added');

        return redirect('/task');
    }


    public function delete($id){
        Task::findOrFail($id)->delete();
        Session::flash('alert-info', 'The task moved to History');


        return redirect('/task');
    }

    public function history(){

        $history = User::find($this->user_id)
            ->tasks()
            ->whereNotNull('deleted_at')
            ->withTrashed()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

//        $paginate = User::paginate(4);
        $historyCount = count($history);

        return view('history', [
            'tasks' => $history,
            'tasksCount' => $historyCount
        ]);
    }

    public function restoreHistory($id){
        Task::withTrashed()->where('id', $id)->restore();
        Session::flash('alert-success', 'Task was restored');
        return redirect('/history');
    }

    public function clearHistory(){

        User::find($this->user_id)
            ->tasks()
            ->whereNotNull('deleted_at')
            ->withTrashed()
            ->forceDelete();

        Session::flash('alert-info', 'History was deleted');
        return redirect('/history');
    }

    public function chat()
    {
        $messages = DB::table('messages')->orderBy('created_at', 'desc')->get();

        for($i = 0; $i < count($messages); $i++){
            $messages[$i]->message = Crypt::decrypt($messages[$i]->message);
        }

        return view('chat', compact(['messages']));


    }

    public function news()
    {
        $news = DB::table('news')->orderBy('created_at', 'desc')->paginate(9);

        return view('news', compact('news'));

    }

    public function newsAdd(Request $request)
    {
        $grabzIt = new GrabzItClient("MDVhNmEzOGFjN2FkNDdiZTg4Y2QzMWZmMDE0M2NiZDU=", "Fgg/Cz96DT90dj8/Pz8/Pz8/eT9YPwI3RGU/BB44bhs=");
//print_r($request->url);
//        die();

        // To take a image screenshot
        $grabzIt->URLToImage($request->url);

        $current_time = time();

        $filepath = $_SERVER['DOCUMENT_ROOT']."/images/".$current_time.".jpg";
        $grabzIt->SaveTo($filepath);


        $news = new News;
        $news->name = $request->name;
        $news->description = $request->description;
        $news->url = $request->url;
        $news->img_name = $current_time.'.jpg';
        $news->save();

        return redirect('/news');
    }

    public function music()
    {
        return view('music');
    }
}
