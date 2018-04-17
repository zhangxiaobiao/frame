<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\UserModel;

class UserController extends \core\Controller
{
    public function __construct()
    {
        $this->denyAccess();
    }

    public function index() {
        $users = UserModel::create()->findAll();
        $data = array(
            'users' => $users,
        );
        $this->loadHtml('user/index', $data);
    }

    public function add() {
        if (empty($_POST)) {
            // 1. 显示添加表单
            $this->loadHtml('user/add');
        } else {
            // 检查用户名是否为空，如果为空，直接提示添加失败,退出程序
            if (empty($_POST['Username'])) {
                return $this->redirect('?p=backend&c=User&a=add', '用户名不能为空，添加失败。');
            }

            // 2. 接收表单提交的值
//            var_dump($_POST);die;
            if (UserModel::create()->add(array(
                //'字段名' => '字段值'
                'name' => $_POST['Username'],
                'nickname' => $_POST['Nickname'],
                'email' => $_POST['Email'],
                'mobile_number' => $_POST['MobileNumber'],
            ))) {
                // 添加成功
                $this->redirect('?p=backend&c=User&a=index', '添加成功。');
            } else {
                // 失败
                $this->redirect('?p=backend&c=User&a=add', '添加失败');
            }
        }
    }
    public function delete() {
        $id = $_GET['id'];
        if (UserModel::create()->deleteById($id)) {
            // 删除成功
            $this->redirect('?p=backend&c=User&a=index', '删除成功');
        } else {
            // 删除失败
            $this->redirect('?p=backend&c=User&a=index', '删除失败，请稍候再试');
        }
    }
    public function update() {
        if (empty($_POST)) {
            // 1.显示修改的表单
            // 1.1 取出要修改的行
            $id = $_GET['id'];
            $user = UserModel::create()->findById($id);
            // 1.2 加载视图
            $this->loadHtml('user/update', array(
                'user' => $user,
            ));
        } else {
            // 2.接收表单传的值
            $id = $_GET['id'];
            if (UserModel::create()->updateById($id, array(
                //'字段名' => '字段值'
                'name' => $_POST['Username'],
                'nickname' => $_POST['Nickname'],
                'email' => str_replace('</script>', '', str_replace('<script>', '', $_POST['Email'])),
                'mobile_number' => $_POST['MobileNumber'],
            ))) {
                // 修改成功
                $this->redirect('?p=backend&c=User&a=index', '修改成功');
            } else {
                // 修改失败
                $this->redirect("?p=backend&c=User&a=update&id={$id}", "修改失败");
            }
        }
    }
}