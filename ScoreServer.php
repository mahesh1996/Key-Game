<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\ScorePublisherController;

require  'vendor/autoload.php';


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ScorePublisherController()
        )
    ),
    8008
);

$server->run();
?>