-- 编号  id 数字
-- 排序 sort 数字 不能为空 默认值0
-- 名字 name 字符串 不能为空
-- 别名 nickname 字符串 不能为空 默认值''
-- 父分类 parent_id 数字 不能为空 默认值0

CREATE TABLE `category` (
  `id` INT PRIMARY KEY auto_increment,
  `sort` INT NOT NULL DEFAULT 0,
  `name` varchar(16) NOT NULL,
  `nickname` varchar(16) NOT NULL DEFAULT '',
  `parent_id` INT NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET utf8;

-- 插入数据
insert into category (id, name, nickname, parent_id, sort) values
(null,'科技','',0,50), -- 1
(null,'武侠','',0,50), -- 2
(null,'旅游','',0,50), -- 3
(null,'美食','',0, 50), -- 4
(null,'IT','',1,50),   -- 5
(null,'生物','',1,50), -- 6
(null,'鸟类','',6,50), -- 7
(null,'湘菜','',4,50), -- 8
(null,'粤菜','',4,50), -- 9
(null,'川菜','',4,50), -- 10
(null,'跳跳蛙','',8,50), -- 11
(null,'口味虾','',8,50), -- 12
(null,'臭豆腐','',8,50), -- 13
(null,'白切鸡','',9,50), -- 14
(null,'隆江猪脚','',9,50); -- 15