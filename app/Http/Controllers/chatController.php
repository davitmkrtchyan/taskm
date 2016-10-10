<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Request;
use LRedis;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class chatController extends Controller {

    private $user_id;

    private $user_name;

	public function __construct()
	{
		$this->middleware('auth');
        $this->user_id = Auth::id();
	}

	public function sendMessage(){
		$redis = LRedis::connection();
		$data = ['message' => Request::input('message'), 'user' => Request::input('user')];
        $message_tb = new Message();
        $message_tb->sender_id = $this->user_id;
        $message_tb->sender_name = Request::input('user');
        $message_tb->message = Crypt::encrypt(Request::input('message'));

        $message_tb->save();
		$redis->publish('message', json_encode($data));
		return response()->json([]);
	}
}