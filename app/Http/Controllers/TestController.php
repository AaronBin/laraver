<?php

namespace App\Http\Controllers;
use App\Http\Requests;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Server $server)
    {
        $server->index();
    }

}
