CREATE DATABASE `php48` DEFAULT CHARSET utf8;

-- 主键 数字（整数） 自增长
-- 用户名 name 字符串 varchar(16) 不能为空 没有默认值
-- 昵称 nickname 字符串 varchar(16) 不能为空 默认值空字符串
-- 邮箱 email 字符串 varchar(200) 不能为空 没有默认值
-- 手机号 mobile_number 字符串 varchar(11) 不能为空 空的默认值
-- 注册时间 register_time 数字 INT 不能为空 默认值为0

CREATE TABLE `user` (
  `id` INT PRIMARY KEY auto_increment,
  `name` VARCHAR(16) NOT NULL,
  `nickname` VARCHAR(16) NOT NULL DEFAULT '',
  `email` VARCHAR(200) NOT NULL,
  `mobile_number` VARCHAR(11) NOT NULL DEFAULT ''
) ENGINE=INNODB DEFAULT CHARSET utf8;


INSERT INTO `user` (`name`, `nickname`, `email`) VALUES
('张飞', '翼得', 'zf@vip.qq.com'),
('刘备', '玄德', 'xd@vip.qq.com'),
('关羽', '云长', 'yc@vip.qq.com');

ALTER TABLE `user` ADD COLUMN `register_time` INT NOT NULL DEFAULT 0;