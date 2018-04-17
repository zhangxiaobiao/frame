
-- 序号 id 数字 主键 自增长
-- 分类的id `category_id` 数字，指向分类表的id
-- 用户的id `user_id` 数字，指向用户表的id
-- 标题 `title` 字符串 不能为空 没有默认值
-- 内容 `content` 很长的字符串 不能为空 没有默认值
-- 发布日期 `date` 数字
-- 状态 `status` 数字 1:草稿 2：公开 3：隐藏
-- 置顶 `top` 数字 1:置顶，2：不置顶

CREATE TABLE `article` (
  `id` INT PRIMARY KEY auto_increment,
  `category_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `title` VARCHAR(30) NOT NULL,
  `content` text,
  `date` INT NOT NULL,
  `status` TINYINT NOT NULL DEFAULT 2,
  `top` TINYINT NOT NULL DEFAULT 2
) ENGINE=INNODB DEFAULT CHARSET utf8;

-- 阅读数 `read_count` 数字 不能为空 默认值0
-- 点赞数 `good` 数字 不能为空 默认值0
ALTER TABLE `article` ADD COLUMN `read_count` INT NOT NULL DEFAULT 0;
ALTER TABLE `article` ADD COLUMN `good` INT NOT NULL DEFAULT 0;





