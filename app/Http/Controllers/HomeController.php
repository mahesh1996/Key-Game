<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;

class HomeController extends Controller
{
    public function index(){

    }
    
    public function login(Request $req){
    	if(Auth::check())
			return redirect()->route('home');
		return view('login');
    }

    public function doLogin(Request $req){
    	if(Auth::attempt(array('username'=>$req->input('username'),'password'=>$req->input('password')),false))
		{
			$user = Auth::user();
			if($user->isFinished()) {
				return redirect()->route('score');
			}
			$user->fname = ucfirst(trim($req->input('fname')));
			$user->lname = ucfirst(trim($req->input('lname')));
			$user->enrollment = trim($req->input('enrollment'));
			$user->save();
			return redirect()->route('home');
		}
		else
		{
			return redirect()->back()->withErrors(['wrong' => 'Invalid Email or Password'])->withInput($req->except('password'));
		}
    }

    public function logout(Request $req)
	{
		if(Auth::check()) {
			$user = Auth::User();
			/*$user->started_on = null;
			$user->ended_on = null;
			$user->score = 0;
			$user->started = false;
			$user->wpm_start_time = null;
			$user->wpm_end_time = null;
			$user->wpm_completed_word = null;
			$user->save();*/
			$req->session()->flush();
			Auth::logout();
		}
		return redirect()->route('keygame');
	}

	public function score(Request $req) {
		return view('score');
	}

	public function updateScore(Request $req) {
		$users = User::whereNotNull('wpm_start_time')->orderBy('score','desc')->get();
		//$users = json_decode($users);
		foreach($users as $singleUser) {
			$start = $singleUser['wpm_start_time'];
			$end = $singleUser['wpm_end_time'];
			if(is_null($end))
				$singleUser['total_time'] = 'In Progress';
			else
				$singleUser['total_time'] = $end - $start;
		}
		//var_dump($users);
		return response()->json($users);
	}
}
