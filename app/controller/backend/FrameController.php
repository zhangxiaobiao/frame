<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

class FrameController extends \core\Controller
{
    public function frame()
    {
        $this->denyAccess();
        // 怎么判断用户有没有登录成功？
        $this->loadHtml('frame/frame');
    }

    public function top()
    {
        $this->denyAccess();
        $this->loadHtml('frame/top');
    }

    public function menu()
    {
        $this->denyAccess();
        $this->loadHtml('frame/menu');
    }

    public function content()
    {
        $this->denyAccess();
        $this->loadHtml('frame/content');
    }
}
















