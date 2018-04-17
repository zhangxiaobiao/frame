<?php

namespace core;
use app\config\Config;

/**
 * 传智播客：高端PHP培训
 * 网站：http://www.itcast.cn
 */
class Model extends \vendor\PDOWrapper
{
    public function __construct()
    {
        // 5千行
        // 模型层99%时间在操作数据库
        parent::__construct(Config::$database);
    }

    public static function create($className = false)
    {
        // 如果没有传$className, $className应该是BaseModel的子类的类名
        if ($className === false) {
            $className = get_called_class();
        }
        static $instance = array();
        if (!isset($instance[$className])) {
            $instance[$className] = new $className();
        }
        return $instance[$className];
    }

    // 查询出所有的数据
    public function findAll($where = '2 > 1')
    {
        $sql = "SELECT * FROM `" . static::$table . "` WHERE {$where}";
        return $this->getAll($sql);
    }

    // 查询一条数据
    public function findById($id)
    {
        $sql = "SELECT * FROM `" . static::$table . "` WHERE id='{$id}'";
        return $this->getOne($sql);
    }

    // 查询一条数据，根据传递的条件查
    public function find($where)
    {
        $table = static::$table;
        $sql = "SELECT * FROM `{$table}` WHERE $where";
        return $this->getOne($sql);
    }

    // 通过id删除一条数据
    public function deleteById($id)
    {
        $sql = "DELETE FROM `" . static::$table . "` WHERE id='{$id}'";
        return $this->exec($sql);
    }

    public function delete()
    {
        return $this->deleteById($this->id);
    }

    // 添加一条数据
    public function add($data)
    {
        //array(
        //    '字段名字' => '字段的值',
        //    '字段2。。.' => '值...'
        //)
        //
        $fields = "";
        $fieldValues = "";
        foreach($data as $field => $fieldValue) {
            $fields .= "`{$field}`,";
            $fieldValues .= "'{$fieldValue}',";
        }
        $fields = rtrim($fields, ',');// 将字符串末尾的,去掉
        $fieldValues = rtrim($fieldValues, ',');
        $table = static::$table;
        $sql = "INSERT INTO `{$table}` ({$fields}) VALUES ({$fieldValues})";
        return $this->exec($sql);
    }

    // 修改一条数据
    public function updateById($id, $data)
    {
        //$data = array(
        //    '字段名字' => '字段的值',
        //    '字段2。。.' => '值...'
        //)
        $sets = "";
        foreach ($data as $field => $fieldValue) {
            $sets .= "`{$field}`='{$fieldValue}',";
        }
        $sets = rtrim($sets, ',');
        $table = static::$table;
        $sql = "UPDATE `{$table}` SET {$sets} WHERE id='{$id}'";
        return $this->exec($sql);
    }

    // 封装查询记录数
    public function getCount($where = '2 > 1')
    {
        $table = static::$table;
        $sql = "SELECT count(*) AS c FROM `{$table}` WHERE {$where}";
        return $this->getOne($sql)->c;
    }
}