<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Server
{

    private $server;

    public function __construct(){

        $this->server = new \swoole_server("0.0.0.0", 9501);
    }

    public function index(){


        //var_dump($this->server);

        echo "okokok";

    }

}
