<?php

namespace app\controller\backend;

use app\model\ArticleModel;
use app\model\CategoryModel;
use core\Controller;
use vendor\Pager;

class ArticleController extends Controller
{
    // add: 添加
    public function add()
    {
        if (empty($_POST)) {
            $categories = CategoryModel::create()->findAll();
            $categories = CategoryModel::create()->limitlessLevelCategory($categories);
            // 1.显示添加表单
            $this->loadHtml('article/add', array(
                'categories' => $categories,
            ));
        } else {
            // 2.获取表单提交的值
            if (ArticleModel::create()->add(array(
                'category_id' => $_POST['CateID'],
                'user_id' => $_SESSION['uid'],
                'title' => $_POST['Title'],
                'content' => $_POST['Content'],
                'date' => strtotime($_POST['PostTime']),
                'status' => $_POST['Status'],
                'top' => isset($_POST['isTop']) ? 1 : 2,
            ))) {
                // 添加成功
                $this->redirect('?p=backend&c=Article&a=index', '添加成功。');
            } else {
                // 添加失败
                $this->redirect('?p=backend&c=Article&a=add', '添加失败');
            }
        }
    }

    public function index()
    {
        // $_REQUEST = $_GET + $_POST
        // 接收查询的关键子
        $where = '2 > 1';
        $categoryId = isset($_REQUEST['category']) ? $_REQUEST['category'] : 0;// 分类
        if ($categoryId) {
            // 传了category_id
            $where .= " AND `article`.`category_id`={$categoryId}";
        }
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;// 1:草稿 2:公开 3: 隐藏
        if ($status) {
            $where .= " AND `article`.`status`={$status}";
        }
        $top = isset($_REQUEST['istop']) ? $_REQUEST['istop'] : 0;// 0表示查询出置顶+不置顶的所有数据
        if ($top) {
            $where .= " AND `article`.`top`=1";
        }
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
        if ($search) {
            $where .= " AND `article`.`title` LIKE '%{$search}%'";
        }
        // echo $where;die;
        $pageSize = 1;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // 进行分页
        $pager = new Pager(ArticleModel::create()->getCount($where), $pageSize, $page, 'index.php', array(
            'p' => 'backend',
            'c' => 'Article',
            'a' => 'index',
            'category' => $categoryId,
            'status' => $status,
            'istop' => $top,
            'search' => $search,
        ));
        $pagerButtons = $pager->showPage();

        $start = ($page - 1) * $pageSize;
        $articles = ArticleModel::create()->findAllWithJoin($where, $start, $pageSize);
        $categories = CategoryModel::create()->findAll();
        $categories = CategoryModel::create()->limitlessLevelCategory($categories);
        $this->loadHtml('article/index', array(
            'articles' => $articles,
            'pagerButtons' => $pagerButtons,
            'categories' => $categories,
            'categoryId' => $categoryId,
            'status' => $status,
            'top' => $top,
            'search' => $search,
        ));
    }
}