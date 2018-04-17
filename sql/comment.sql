
-- id                 数字 INT 不能为空 没有默认值 主键 自增
-- 评论的内容           字符串 varchar(200) 不能为空 没有默认值
-- 发布时间             数字 INT 不能为空 没有默认值
-- 评论的作者           数字 INT 不能为空 没有默认值
-- 评论的那个文章        数字 INT 不能为空 没有默认值
-- 上级评论             数字 INT 不能为空 默认值0


CREATE TABLE `comment` (
  `id` INT NOT NULL PRIMARY KEY auto_increment,
  `content` VARCHAR(200) NOT NULL,
  `time` INT NOT NULL,
  `user_id` INT NOT NULL,
  `article_id` INT NOT NULL,
  `parent_id` INT NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET utf8;

INSERT INTO `comment` (`id`, `user_id`, `article_id`, `parent_id`, `content`, `time`) VALUES
(NULL, 1, 1, 0, '么么哒', 1464936963),
(NULL, 3, 2, 1, '么么哒2', 1464936963),
(NULL, 2, 3, 0, '么么哒3', 1464936963),
(NULL, 1, 1, 0, '么么哒4', 1464936963),
(NULL, 2, 1, 0, '么么哒5', 1464936963),
(NULL, 1, 1, 0, '么么哒6', 1464936963);