<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */

namespace app\controller\frontend;

use app\model\ArticleModel;
use app\model\CategoryModel;
use app\model\CommentModel;
use core\Controller;
use vendor\Pager;

class ArticleController extends Controller
{
    public function index()
    {
        $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
        $categoryId = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;

        $where = '2 > 1';
        if ($search) {
            // 用户传递了搜索条件
            $where .= " AND `article`.`title` LIKE '%{$search}%'";
        }
        if ($categoryId) {
            $where .= " AND `article`.`category_id`='{$categoryId}'";
        }
        // 分页
        $pageSize = 1;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $pager = new Pager(ArticleModel::create()->getCount($where), $pageSize, $currentPage, 'index.php', array(
            'p' => 'frontend',
            'c' => 'Article',
            'a' => 'index',
            'search' => $search,
            'category_id' => $categoryId,
        ));
        $pagerLinks = $pager->showPage();
        // 1.查询出所有的文章
        $start = ($currentPage - 1) * $pageSize;
        $articles = ArticleModel::create()->findAllWithJoin($where, $start, $pageSize);
        // var_dump($articles);die;
        // 2.查询出所有的分类，并进行无限极分类
        $categories = CategoryModel::create()->findAll();
        $categories = CategoryModel::create()->limitlessLevelCategory($categories);

        // 3.调用smarty的assign将所有文章和所有的分类传递到html里
        $this->s->assign(array(
            'articles' => $articles,
            'categories' => $categories,
            'search' => $search,
            'pagerLinks' => $pagerLinks,
            'categoryId' => $categoryId,
        ));
        // 4.调用smarty的display方法关联app/view/frontend/article/index.html
        $this->s->display('frontend/article/index.html');
    }

    // 显示博客的详情页
    public function content()
    {
        // 接收$id=$_GET['id'];
        $id = $_GET['id'];

        // 阅读数+1 update article set read_count=read_count+1 where id=$id
        ArticleModel::create()->addReadCount($id);

        // 调用ArticleModel查询出文章的所有字段，包括作者的名字，分类的名字，评论的数量
        $article = ArticleModel::create()->findOneWithJoin($id);
        // 调用CommentModel查询文章id为$id的所有的评论，包括评论的作者名字
        $comments = CommentModel::create()->findAllWithJoin("`comment`.`article_id`='{$id}'");
        // 对文章的评论做无限极分类
        $comments = CommentModel::create()->limitlessLevelComment($comments);
        // 调用smarty的assign方法将$article, $comments传递到视图里
        $this->s->assign(array(
            'article' => $article,
            'comments' => $comments,
        ));
        // 调用smarty的display方法关联app/view/frontend/article/content.html
        $this->s->display('frontend/article/content.html');
    }

    // 点赞
    public function good()
    {
        $id = $_GET['article_id'];
        $url = "?p=frontend&c=Article&a=content&id={$id}";
        if (isset($_SESSION["flag_{$id}"]) && $_SESSION["flag_{$id}"]) {
            // 表示用户已经赞过
            return $this->redirect($url, "已经赞过，不能重复点赞。");
        }
        if (ArticleModel::create()->addGoodCount($id)) {
            // 点赞成功
            $_SESSION["flag_{$id}"] = true;
            $this->redirect($url, "点赞成功");
        } else {
            // 点赞失败
            $this->redirect($url, "点赞失败，请稍后再试");
        }
    }
}













