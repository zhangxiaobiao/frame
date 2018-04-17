<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\UserModel;
use core\Controller;
use vendor\Captcha;

class LoginController extends Controller
{
    public function login()
    {
        // 用户提交的验证码: $_POST['edtCaptcha']
        if (empty($_POST)) {
            // 1. 显示登录的表单
            $this->loadHtml('login/login');
        } else {
            // 验证验证码是否正确
            if (strtolower($_POST['edtCaptcha']) != $_SESSION['trueCaptcha']) {
                $this->redirect('?p=backend&c=Login&a=login', '验证码错误。');
                die();
            }
            // 2. 获取表单提交的值
            $username = addslashes($_POST['username']);
            $password = $_POST['password'];
            // 通过用户名和密码组合到数据库确认符合的用户是否存在
            $user = UserModel::create()->find("password='{$password}' AND name='{$username}'");
            if ($user == false) {
                $_SESSION['loginSuccess'] = false;
                // 没有找到该用户 => 用户名或密码错误
                $this->redirect('?p=backend&c=Login&a=login', '登录失败，请稍后再试。');
            } else {
                // 登录成功后，将当前用户id存到session
                $_SESSION['uid'] = $user->id;
                $_SESSION['user'] = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'nickname' => $user->nickname,
                    'email' => $user->email,
                    'mobile_number' => $user->mobile_number,
                    'register_time' => $user->register_time,
                    'current_time' => time(),
                    'current_ip' => $_SERVER['REMOTE_ADDR'],
                    // ....
                );
                // 找到用户，登录成功
                $_SESSION['loginSuccess'] = true;
                $this->redirect('?p=backend&c=Frame&a=frame', '登录成功');
            }
        }
    }

    // 输出验证码图片
    public function captcha()
    {
        $obj = new Captcha();
        $obj->generateCode();
        $_SESSION['trueCaptcha'] = $obj->getCode();// 拿到验证码图片里的字符串
    }

    // 退出
    public function logout()
    {
        // $_SESSION['loginSuccess'] = false;
        unset($_SESSION);
        session_destroy();
        $this->redirect('?p=backend&c=Login&a=login', '退出成功。');
    }
}