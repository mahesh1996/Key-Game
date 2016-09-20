<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Session\SessionManager;
use App\User;
use Crypt;
use App;
use Config;

class ScorePublisherController implements MessageComponentInterface
{
    protected $clients;
    private $subscriptions;
    private $users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $session = (new SessionManager(App::getInstance()))->driver();
	    // Get the cookies
	    $cookies = $conn->WebSocket->request->getCookies();
	    // Get the laravel's one
	    $laravelCookie = urldecode($cookies[Config::get('session.cookie')]);
	    // get the user session id from it
	    $idSession = Crypt::decrypt($laravelCookie);
	    // Set the session id to the session handler
	    $session->setId($idSession);
	    // Bind the session handler to the client connection
	    $conn->session = $session;
    }

    public function onMessage(ConnectionInterface $conn, $msg)
    {
    	$conn->session->start();

        $data = json_decode($msg);
        $conn->session->put('scores', $data[0]);
        $conn->session->save();
     	//$user = DB::table('users')->where('id', $data->userid)->first();
     	$user = User::find($data[1]->userid);
     	//$user->score = $data[1]->score;
     	if(!$user->isFinished()){
	     	$user->wpm_start_time = $data[1]->wpmStartTime;
	     	$user->wpm_completed_word = $data[1]->completedWord;
	     	$user->score = $data[1]->score;
	     	$user->save();
     	}
     	$scores = User::whereNotNull('fname')->select('fname','lname','score')->orderBy('score','desc')->get();
     	foreach ($this->clients as $client) {
            $client->send(json_encode($scores));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
