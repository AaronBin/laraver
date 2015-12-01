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

        //设置返回结果集为php数组格式
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
        echo "</pre>";*/


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
            '永利宝金融',
            'Laravel-简洁、优雅的PHP开发框架,',
            '(PHP Web Framework)。- Laravel,',
            '2015年3月7日 - 推荐新建一个名为 laravel5,',
            '2014年10月30日 - $builder在laravel中真是太TMD好用了',
            'Sphinx （一种全文检索引擎）,',
            '全球首款GPU加速的HTML5处理引擎,',
            '可以结合MySQL,PostgreSQL做全文搜索,',
            '它可以提供比数据库本身更专业的搜索功能,',
            '使得应用程序更容易实现专业化的全文检索。',
            'Sphinx特别为一些脚本语言设计搜索API接口,',
            '如PHP,Python,Perl,Ruby等，同时为MySQL也设计了一个存储引擎插件。',
            '高速索引 (在新款CPU上,近10 MB/秒);',
            '高速搜索 (2-4G的文本量中平均查询速度不到0.1秒);',
            '高可用性 (单CPU上最大可支持100 GB的文本,100M文档);',
            '提供良好的相关性排名',
            '提供从MySQL内部的插件式存储引擎上搜索',
            '支持每个文档多个全文检索域(默认最大32个);',
            'Sphinx is a full-text search engine,',
            ' publicly distributed under GPL version 2.',
            'Commercial licensing ',
            '(eg. for embedded use)',
            ' is available upon request.',
            'Technically, Sphinx is a ',
            'standalone software package provides',
            'fast and relevant full-text ',
            'search functionality to client applications.',
            'It was specially designed to ',
            'integrate well with SQL databases storing the data,',
            ' and to be easily accessed ',
            'by scripting languages. However, ',
            'hello world,',
            'Applications can access ',
            'Sphinx search daemon (searchd) using ',
            'any of the three different access methods: a) ',
            'via Sphinx own implementation',
            ' of MySQL network protocol ',
            '(using a small ',
            'SQL subset called SphinxQL,',
            'Official native SphinxAPI ',
            'implementations for PHP, Perl, Python, ',
            'Ruby and Java are included',
            ' within the distribution package. ',
            'API is very lightweight so porting it to a new language',
            'is known to take a few hours ',
            'or days. Third party API ports and ',
            'plugins exist for Perl, C#, Haskell, Ruby-on-Rails,',
            'and possibly other languages and frameworks.',
            'Data can be loaded into disk ',
            'indexes using a so-called data source. ',
            'Built-in sources can fetch',
            ' data directly from MySQL, PostgreSQL, ',
            'MSSQL, ODBC compliant database ',
            '(Oracle, etc) or a pipe in TSV or a custom XML format. ',
            'Adding new data sources ',
            'drivers (eg. to natively support',
            ' other DBMSes) is designed ',
            'to be as easy as possible. ',
            'RT indexes, as of 1.10-beta, ',
            'can only be populated using SphinxQL.',
            '永利宝（www.yonglibao.com）',
            '在线投融资理财平台，',
            '在汲取国外P2P互联网金融经验后，',
            '基于中国国情，首次提出了创新概念的PCP(Person-Company-Person)',
            '互联网金融运营模式，',
            '只撮合中低风险与稳定回报',
            '（年化收益约6%-18%）的融资交易，',
            '并在交易过程中引入各类持有金融牌照的小额贷款公司、',
            '典当行、国有大中型融资性担保机构,',
            '以及各类高信用大型民营融资性担保机构、',
            '知名投资公司（合称“小担当”）',
            '作为保证人，',
            '以降低项目投资风险。',
            '永利宝于2014年获得乾道控股',
            '1000万人民币风险投资，',
            '并于2015年初获得汉',
            '理资本千万美金级风险投资。',
            '永利宝_怎么样_可靠吗_收益率 - 融360,',
            '支付宝里的永利宝投资软件',
            '找不到了_百度知道',
            '永利宝获1亿元B轮融资',
            ' 风投或不再疯投P2P|人民币|',
            '永利_凤凰财经,',
            '中新网湖北,',
            ' 永利宝:投资恒久远,',
            '风控需传承,',
            '2015年10月22日',
            ' - 一个没有像陆金所',
            '这样雄厚背景、',
            '没有像拍拍贷这样',
            '老字号招牌的永利宝何以发展如此之快,',
            '余刚说,秘诀只有两个字,',
            '风控。据悉,永利宝的风控在行业内是出..',
            '网贷之家是第三方网贷资讯平台，',
            '于2011年10月上线。',
            '网贷之家致力推动P2P网贷行业发展，',
            '打造网贷行业最有影响力的资讯门户，',
            '是投资人身边的网贷咨询专家，',
            '为投资者的网贷之路保驾护航。',
            '网贷之家于2011年10月上线，',
            '隶属于上海盈灿投资',
            '管理咨询有限公司，',
            '是第三方网贷资讯平台，',
            '网贷之家致力推动P2P网贷行业',
            '发展的资讯门户网站。',
            '上海盈灿投资管理咨询有限公司',
            '位于上海市虹口区大连路1619',
            '号骏丰国际财富广场504室 。',
            'P2P网络借贷行业是一个年轻的朝阳产业，',
            '自2007年传入中国，',
            '近几年发展迅速。',
            '在此背景下，',
            '网贷之家应运而生，',
            '为网贷人提供了一个平等、',
            '公开、透明的网贷交流平台。',
            '网贷之家网站的诞生、',
            '在网络借贷行业及社会媒体中引起强烈关注，',
            '先后有《新华社》[1]  、',
            '《中央人民广播电台》、',
            '《中国证卷报》[2]  、',
            '《第一财经电视台》、',
            '《第一财经日报》[3]  、',
            '《深圳商报》[4]  、',
            '《新民晚报》[5]  、',
            '《每日经济观察报》、',
            '《法制周刊》、',
            '《南方农村报》[6] ',
            ' 等十几家媒体进行专访、',
            '报道。网贷之家网站已发展',
            '为网络借贷行业最大、',
            '最权威的第三方资讯平台，',
            '并曾为上海市政府对行业',
            '调研提供咨询参考。',
            '网贷投资人来自全国各地，',
            '然后又投资全国各地的平台，',
            '当初的想法就是希望全国各',
            '地的投资人无论投资哪里的平台，',
            '都可以拥有一个共同的家园，',
            '鉴于这种想法，',
            '我们取名“网贷之家”。',
            '“z”取的是“中”立 与公“正”拼音首字母，',
            '也是表达我们立场的意思。',
            'PHP（外文名:PHP: Hypertext Preprocessor，',
            '中文名：“超文本预处理器”）',
            '是一种通用开源脚本语言。',
            '语法吸收了C语言、Java和Perl的特点，',
            '利于学习，使用广泛，',
            '主要适用于Web开发领域。',
            'PHP 独特的语法混合了C、Java、Perl',
            '以及PHP自创的语法。',
            '它可以比CGI或者Perl更快速地执行动态网页。',
            '用PHP做出的动态页面与其他的编程语言相比，',
            'PHP是将程序嵌入到HTML',
            '（标准通用标记语言下的一个应用）',
            '文档中去执行，',
            '执行效率比完全生成HTML标记的CGI要高许多；',
            'PHP还可以执行编译后代码，',
            '编译可以达到加密和优化代码运行，',
            '使代码运行更快。'
        );

        for ($x=0; $x<1000000; $x++)
        {
            $nn = rand(0,158);
            $n1 = rand(0,158);
            $n2 = rand(0,158);
            $title = $data[$nn];
            $content = $data[$n1].$data[$nn].$data[$n2];
            $title = $title.md5($title);
            $content = $content.md5($content);

            $sql = "INSERT INTO documents(group_id,group_id2,date_added,title,content) VALUES(3,6,NOW(),'{$title}','{$content}');";
            //DB::insert($sql);
        }

    }
}
