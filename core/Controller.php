<?php

namespace core;

use vendor\Smarty;

/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
class Controller
{
    protected $s;
    
    public function __construct()
    {
        $this->createSmartyObject();
    }

    protected function createSmartyObject()
    {
        $s = new Smarty();
        // templates_c放到系统的临时目录
        $s->setCompileDir(sys_get_temp_dir() . '/templates_c');
        // configs 放到 app/config
        $s->setConfigDir('./app/config');
        // templates 放到 app/view
        $s->setTemplateDir(VIEW_PATH);
        $s->left_delimiter = '<{';
        $s->right_delimiter = '}>';

        $this->s = $s;
    }

    // 用户没有登录，跳转到登录页登录，用户登录，啥也不做
    public function denyAccess()
    {
        if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']) {
            // 用户已登陆
            // 暂时不做什么
        } else {
            // 用户未登录
            $this->redirect('?p=backend&c=Login&a=login', '禁止访问。');
            die;
        }
    }

    protected function redirect($url, $message = "", $time = 3, $type = 1)
    {
        // $type == 1显示用户友好的提示信息，$type==2显示用户不友好的提示信息
        if ($type == 2) {
            header("Refresh: {$time}; url={$url}");
            echo $message;
        } else {
            // 显示用户友好的提示信息
            require VIEW_PATH . '/tip.html';
        }
    }

    public function loadHtml($htmlName, $data = array())
    {
//        $users = $data['users'];
//        $name = $data['name'];
//        $a = $data['a'];
        foreach($data as $variableName => $variableValue) {
            $$variableName = $variableValue;
        }
        require VIEW_PATH . "/" . PLATFORM . "/{$htmlName}.html";
    }
}









