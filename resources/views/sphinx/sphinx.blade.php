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
            

        </style>
    </head>
    <body>
        <div class="container">
            <form action="/sphinx/search">
                <div>
                        <div class="div-search">
                            <input type="text" name="search" class="text-search">&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" class="button-search"><br/>
                            <h5>{{$data}}</h5>
                        </div>
                    <table>
                    </table>
                  </div>
            </form>
        </div>
    </body>
</html>
