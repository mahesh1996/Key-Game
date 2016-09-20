<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\COntrollers\ScorePublisherController as Score;

class ServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the Ratchet websocket server on port 8008';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $server = IoServer::factory(new HttpServer(new WsServer(new Score)), 8008);
        $server->run();
    }
}