<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\model;

use core\Model;

class CommentModel extends Model
{
    public static $table = 'comment';

    // 返回所有的评论
    public function findAllWithJoin($where = '2 > 1')
    {
        $sql = "SELECT `comment`.*, a.content AS parent_content, `user`.`name` AS user_name, `article`.`title`
                FROM `comment`
                LEFT JOIN `comment` AS a ON `comment`.`parent_id`=a.`id`
                LEFT JOIN `user` ON `comment`.`user_id`=`user`.`id`
                LEFT JOIN `article` ON `comment`.`article_id`=`article`.`id`
                where {$where}";
        return $this->getAll($sql);
    }

    // 分类的无限极分类
    // array(
    //      array(
    //          'id' => 1,
    //          'childrens' => array(
    //              'id' => 2,
    //              'childrens' => array(
    //                  'id' => 3,
    //                  'childrens' => array(
    //                      'id' => 7
    //                  ),
    //              ),
    //           ),
    //      ),
    //      array(
    //          'id' => 4,
    //          'childrens' => array(
    //              'id' => 5,
    //              'childrens' => array(
    //                  'id' => 6,
    //              ),
    //           ),
    //      ),
    //);
    public function limitlessLevelComment($comments, $parentId = 0)
    {
        $treeComments = array();
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                // 寻找评论的子评论
                $comment->childrens = $this->limitlessLevelComment($comments, $comment->id);
                $treeComments[] = $comment;
            }
        }
        return $treeComments;
    }
}














