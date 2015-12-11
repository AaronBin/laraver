<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        echo 11;exit();
    }


    public function __call($function,$parameter){


        $arg = [
            1,
            2,
            3,
            4
        ];
        call_user_func_array(array($this,'callback'),array($arg));
    }

    public function callback($uid){

       var_dump($uid);
    }


    public function app(AboutController $about){

    }

}
