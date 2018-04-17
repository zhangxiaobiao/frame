<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\controller\backend;

use app\model\CommentModel;
use core\Controller;

class CommentController extends Controller
{
    // 评论列表
    public function index()
    {
        // 1.查询出所有的评论
        $comments = CommentModel::create()->findAllWithJoin();
        // 2.加载html
        $this->loadHtml('comment/index', array(
            'comments' => $comments,
        ));
    }
}










