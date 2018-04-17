<?php
/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
namespace app\model;

use core\Model;

class CategoryModel extends Model
{
    public static $table = 'category';

    // 无限极分类 limitless: 无限, level:级别， category:分类
    public function limitlessLevelCategory($categories, $parentId = 0, $level = 0)
    {
        static $limitlessCategories = array();
        foreach($categories as $category) {
            // 只返回顶级分类 parent_id=0，最顶级的级别是0，顶级的下一级1
            if ($category->parent_id == $parentId) {
                $category->level = $level;
                $limitlessCategories[] = $category;
                $this->limitlessLevelCategory($categories, $category->id, $level + 1);
            }
        }
        return $limitlessCategories;
    }

    public function findAllWithJoin()
    {
        $sql = <<<SQL
    SELECT `category`.*, count(`article`.`id`) AS article_count
    FROM `category`
    LEFT JOIN `article` ON `article`.`category_id`=`category`.`id`
    GROUP BY `category`.`id`;
SQL;
        return $this->getAll($sql);
    }
}