<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\CategoryModel;
use core\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->denyAccess();
    }

    // 列表
    public function index() {
        $categories = CategoryModel::create()->findAllWithJoin();
        $categories = CategoryModel::create()->limitlessLevelCategory($categories);
        //var_dump($categories);die;
        $this->loadHtml('category/index', array(
            'categories' => $categories,
        ));
    }
    // 添加
    public function add() {
        if (empty($_POST)) {
            // 显示添加的表单
            $categories = CategoryModel::create()->findAll();
            $categories = CategoryModel::create()->limitlessLevelCategory($categories);
            $this->loadHtml('category/add', array(
                'categories' => $categories,
            ));
        } else {
            // 获取表单提交的值
            // var_dump($_POST);die;
            if (CategoryModel::create()->add(array(
                'sort' => $_POST['Order'],
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'parent_id' => $_POST['ParentID'],
            ))) {
                $this->redirect('?p=backend&c=Category&a=index', '添加成功');
            } else {
                $this->redirect('?p=backend&c=Category&a=add', '添加失败，请稍候再试');
            }
        }
    }
    // 删除
    public function delete() {
        $id = $_GET['id'];
        if (CategoryModel::create()->getCount("parent_id='{$id}'") > 0) {
            // 有子分类，不允许删除
            $this->redirect('?p=backend&c=Category&a=index', '不允许删除有子分类的分类。');
            die;
        }
        if (CategoryModel::create()->deleteById($id)) {
            // 删除成功
            $this->redirect('?p=backend&c=Category&a=index', '删除成功.');
        } else {
            // 删除失败
            $this->redirect('?p=backend&c=Category&a=index', '删除失败，请稍候再试。');
        }
    }
    // 修改
    public function update() {
        $id = $_GET['id'];
        if (empty($_POST)) {
            // 通过id找出这个id对应的所有的数据
            $category = CategoryModel::create()->findById($id);
            // 获取所有的分类
            $categories = CategoryModel::create()->findAll();
            // 对所有的分类做无限极分类
            $categories = CategoryModel::create()->limitlessLevelCategory($categories);
            // 1.显示修改的表单
            $this->loadHtml('category/update', array(
                'category' => $category,
                'categories' => $categories,
            ));
        } else {
            // 比较修改前和修改后有没有数据发生修改，没有数据发生修改，直接提示修改成功
//            $oldCategory = CategoryModel::create()->findById($id);
//            if (
//                ($oldCategory->name == $_POST['Name'])
//                &&
//                ($oldCategory->nickname == $_POST['Alias'])
//                &&
//                ($oldCategory->sort == $_POST['Order'])
//                &&
//                ($oldCategory->parent_id == $_POST['ParentID'])
//            ) {
//                // 修改前和修改后数据没有发生改变
//                $this->redirect("?p=backend&c=Category&a=index", "修改成功");
//                die();
//            }
            // 2.接收表单提交的值
            $flag = CategoryModel::create()->updateById($id, array(
                'name' => $_POST['Name'],
                'nickname' => $_POST['Alias'],
                'sort' => $_POST['Order'],
                'parent_id' => $_POST['ParentID'],
            ));
            if ($flag === 1 || $flag === 0) {
                // 修改成功
                $this->redirect('?p=backend&c=Category&a=index', '修改成功');
            } else {
                // 修改失败
                $this->redirect("?p=backend&c=Category&a=update&id={$id}", '修改失败，请稍后再试');
            }
        }
    }
}