<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\frontend;

use app\model\ArticleModel;
use core\Controller;

class TestController extends Controller
{
    public function a()
    {
        var_dump($this->s);
    }

    public function b()
    {
        $articles = ArticleModel::create()->findAllWithJoin();
        var_dump($articles);
    }

    public function c()
    {
        $str = '<div>123</div><img src="123" />';
        echo $str;
        echo "\r\n";
        echo strip_tags($str);
    }

    public function d()
    {
        $str = '<div>123</div><img src="https://msc.blob.core.chinacloudapi.cn/mscmedia/2015-10-30/10-10/222.png.big" /><p>234</p>';
        $pregex = "/\"([https|http]+\:.+)\"/i";
        $matchs = array();
        preg_match($pregex, $str, $matchs);
        print_r($matchs);
    }
}













