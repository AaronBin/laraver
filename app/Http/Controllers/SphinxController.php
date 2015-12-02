<?php

namespace App\Http\Controllers;

use Behavior\ReadHtmlCacheBehavior;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class SphinxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sphinx()
    {
        return view('/sphinx.sphinx')->with('data','请输入您要搜索的关键字...');

    }

    /**
     * sphinx search
     */
    public function sphinxSearch(Request $request,\SphinxClient $sphinx)
    {

        $search = $request->get('search');


        //sphinx的主机名和端口
        $sphinx->SetServer('127.0.0.1',9312);

        //设定搜索模式 SPH_MATCH_ALL(匹配所有的查询词)
        $sphinx->SetMatchMode(SPH_MATCH_ALL);

        //设置返回结果集为数组格式
        $sphinx->SetArrayResult(true);

        //匹配结果的偏移量，参数的意义依次为：起始位置，返回结果条数，最大匹配条数
        $sphinx->SetLimits(0,20,1000);

        //最大搜索时间
        $sphinx->SetMaxQueryTime(10);


        //索引源是配置文件中的 index 类，如果有多个索引源可使用,号隔开：'email,diary' 或者使用'*'号代表全部索引源

        $result = $sphinx->query($search,'*');

        //关闭查询连接
        $sphinx->close();

        //打印结果
        /*echo "<pre>";
        print_r($result);
        echo "</pre>";exit();*/


        $ids = [0];
        if(!empty($result)){
            foreach($result['matches'] as $key=>$val){
                $ids[] = $val['id'];
            }
        }

        $ids = implode(',',array_unique($ids));

        $list = DB::select("SELECT * from documents WHERE id IN ($ids)");
        if(!empty($list)){
            foreach($list as $key=>$val){
                $val->content = str_replace($search,'<span style="color: red;">'.$search.'</span>',$val->content);
                $val->title = str_replace($search,'<span style="color: red;">'.$search.'</span>',$val->title);
            }
        }

        return view('/sphinx.search')->with('data',
            array(
                'total'=> $result['total'] ? $result['total'] : 0,  //索引中匹配文档的总数
                'time' => $result['time'] ? $result['time'] : 0,    //本次搜索耗时
                'list' => $list                                     //返回结果
            )
        );


    }




    public function data(){

        $data = array(
            0=>array('test three','this is my test document number three. also checking search within phrases.'),
            1=>array('test five','this is my test document number five. also checking search within phrases.'),
            2=>array('test five','this is my test document number five. also checking search within phrases.'),
            3=>array('test six','this is my test document number six. also checking search within phrases.'),
            4=>array('test seven','this is my test document number seven. also checking search within phrases.'),
            5=>array('test seven','this is my test document number seven. also checking search within phrases.'),
            6=>array('test eight','this is my test document number eight. also checking search within phrases.'),
            7=>array('test nine','this is my test document number nine. also checking search within phrases.'),
            8=>array('About Laravel','The Laravel framework has a few system requirements. Of course, all of these requirements are satisfied by the Laravel Homestead virtual machine'),
            9=>array('Sphinx overview','Sphinx is an open source full text search server, designed from the ground up with performance, relevance (aka search quality),'),
            10=>array('Sphinx License','The Sphinx Search server is dual-licensed, thus it can be either commercially licensed or freely available via the Downloads page if used in accordance with the terms of the GPL v.2'),
            11=>array('hello world','hello World hello World hello World'),
            14=>array('hello','hello World hello World'),
            12=>array('hello','hello World'),
            13=>array('永利宝','永利宝是一家金融网站'),
        );

        for ($x=0; $x<1000000; $x++)
        {
            $key = rand(0,14);
            $title = $data[$key][0];
            $content = $data[$key][1];
            $sql = "INSERT INTO documents(group_id,group_id2,date_added,title,content) VALUES(3,6,NOW(),'{$title}','{$content}');";
            DB::insert($sql);
        }

    }
}
