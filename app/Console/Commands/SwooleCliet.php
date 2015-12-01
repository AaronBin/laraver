<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleCliet extends Command
{
    private $client;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = new \swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect() {

        if( !$this->client->connect("127.0.0.1", 9501 , 1) ) {
            echo "Error\n";
        }
        $message = $this->client->recv();
        echo "Get Message From Server:{$message}\n";

        fwrite(STDOUT, "请输入消息：");
        $msg = trim(fgets(STDIN));
        $this->client->send( $msg );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }


}

$client = new SwooleCliet();
$client->connect();
