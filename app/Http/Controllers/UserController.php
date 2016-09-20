<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{
	public function homePage(Request $req) {
		$user = Auth::User();
		return view('home',['name' => $user->fname, 'score' => $user->score, 'userid' => $user->id]);
	}

	public function prepareData(Request $req) {
		$user = Auth::User();
		$user->save();
		if($req->session()->has('scores')){
			return response()->json(
				$req->session()->get('scores')
			);
		}
		else {
			$length = config('keyboardgamer.word_length');
			$no_of_word = config('keyboardgamer.total_word');
			$data = array();
			$i=0;
			while($i < $no_of_word) {
				$str = $this->generateRandomString($length);
				if(in_array($str, $data))
					continue;
				else
					$data[$str] = 0;
				$i++;
			}
			$req->session()->put('scores', $data);
			return response()->json($data);
		}
	}

	public function prepareClock(Request $req) {
		$user = Auth::User();
		if(!$user->isStarted()) {
			$now = Carbon::now('Asia/Kolkata');
			$user->started_on = $now;
			$user->save();
			$time = config('keyboardgamer.time_limit');
			$timeSecond = $time*60;
			return response()->json(['time'=>$timeSecond]);
		}
		else if($user->isFinished()) {
			return response()->json(['time'=>1]);
		}
		else {
			$start = Carbon::createFromFormat('Y-m-d H:i:s', $user->started_on , 'Asia/Kolkata');
			$now = Carbon::now('Asia/Kolkata');
			//$nowString = Carbon::createFromFormat('Y-m-d H:i:s', $now->toDateTimeString() , 'Asia/Kolkata');
			$diff = $start->diffInSeconds($now);
			$time = config('keyboardgamer.time_limit');
			$remaining = ($time*60) - $diff ;
			if($remaining <= 0)
				$remaining = 1;
			return response()->json(['time'=>$remaining]);
		}

	}

	public function getUserStatus(Request $req) {
		$user = Auth::User();
		if($user->started == 1) {
			return response()->json(['status' => 'started']);
		}
		else {
			return response()->json(['status' => 'notstarted']);
		}
	}

	public function getWpmStartTime(Request $req) {
		$user = Auth::User();
		if($user->started) {
			return response()->json(['time' => $user->wpm_start_time, 'completedWord' => $user->wpm_completed_word]);
		}
	}

	public function finish(Request $req) {
		$user = Auth::User();
		if($user->isFinished()) {
			return response()->json(['page' => 'score']);
		}
		else {
			$end = $req->input('endTime');
			$now = Carbon::now('Asia/Kolkata');
			$user->ended_on = $now;
			$user->wpm_end_time = $end;
			$user->score = (60*$user->wpm_completed_word)/(($end - $user->wpm_start_time)/1000);
			
			$user->save();
			//redirect to score page
			return response()->json(['page' => 'score']);
		}
	}

    public function generateRandomString($length) {
    	$characters = config('keyboardgamer.characters');
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
