<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <!--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">-->

        <style>
            html, body {
                height: 100%;
            }
            .div-search{
                margin-bottom: 50px;
            }
            .text-search{
                width: 500px;
                height: 30px;
                border-color: #bababb;
            }
            .button-search{
                width: 120px;
                background-color: #2963a3;
                font-size: 20px;
                color: #fffff6;
                border: 0px;
                height: 33px;
            }
            th{
                font-size: 20px;
                height: 100px;
            }
            tr{
                height: 70px;
                line-height: 23px;
            }
            td{
                border-bottom: 1px solid #DDD;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <form action="/sphinx/search">
                <div>
                        <div class="div-search">
                            <input type="text" name="search" class="text-search">&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button-search">
                        </div>

                        <div>
                            <h3>本次查询总结果(条):{{$data['total']}}</h3>
                            <h3>本次查询总耗时(秒):{{$data['time']}}</h3>
                        </div>
                    <table>
                        <tr><th>标题</th><th>内容</th></tr>
                        @foreach($data['list'] as $val)
                            <tr><td>{!! $val->title !!}</td><td>{!! $val->content !!}</td></tr>
                        @endforeach
                    </table>
                  </div>
            </form>
        </div>
    </body>
</html>
