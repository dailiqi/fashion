DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `serial` varchar(64) NOT NULL DEFAULT '' COMMENT '唯一登陆串',
  `time` int(10) NOT NULL COMMENT '创建时间',
  user_name char(255) NOT NULL default "" unique,
  nick_name char(255) NOT NULL default "",
  `token` CHAR(255) NOT NULL DEFAULT "",
  password char(255) NOT NULL default "" comment "登录密码",
  `profile_url` VARCHAR(1024) NOT NULL DEFAULT  "",
  wx_access_token VARCHAR(1024) NOT NULL DEFAULT "",
  wb_access_token VARCHAR(1024) NOT NULL DEFAULT "",
  PRIMARY KEY (`id`),
  INDEX `index_user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_follow`;
CREATE TABLE `user_follow` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL COMMENT '被关注人ID',
  `follower_id` int(10) NOT NULL Comment '粉丝ID',
  `is_delete` tinyint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`),
  INDEX `index_follower_id` (`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL default 0 COMMENT '用户ID',
  `stature` char(10) NOT NULL default "" COMMENT '身高 传递float值',
  `weight` char(10) NOT NULL  default "" COMMENT '体重 传递float值',
  `feature` tinyint(4) NOT NULL default 0 COMMENT '脸型 1曲线形 2中间形 3直线形',
  `somatotype` tinyint(4) NOT NULL default 0 COMMENT '体型 1沙漏 2V型 3梨子 4H 5S 6干瘦',
  `complexion` tinyint(4) NOT NULL default 0 COMMENT '肤色 1白 2偏白略黄 3黄 4偏黑',
  `styles` VARCHAR(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cloth`;
CREATE TABLE `cloth` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `time` int(10) NOT NULL COMMENT '创建时间',
  `url` VARCHAR(2048) NOT NULL DEFAULT 0 COMMENT '存储URL',
  `color_id` int(10) NOT NULl DEFAULT 0 COMMENT '颜色id，对应颜色表',
  `fabric_id` int(10) NOT NULL DEFAULT 0 COMMENT '面料，对应面料表',
  `fabric_sub_id` int(10) NOT NULL DEFAULT 0 COMMENT '面料，对应面料表',
  `contour` char(4) NOT NULL DEFAULT 0 COMMENT '廓形 H型	A型	V型	X型	O型	S型',
  `specific` tinyint(4) NOT NULL DEFAULT 0 COMMENT '细节 1.图案花边	2.工艺加工	3.领边处理	4.腰部处理	5.袖口处理	6.裤边处理',
  `cloth_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '服装类型',
  `cloth_sub_type` int(10) NOT NULL DEFAULT 0 COMMENT '服装细分类',
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`),
  INDEX `index_type` (`cloth_type`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cloth_ext`;
CREATE TABLE `cloth_ext` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT 0,
  `use_count` int(10) NOT NULL DEFAULT 0,
  `is_sweety` tinyint(4) NOT NULL DEFAULT 0,
  `is_lightripe` tinyint(4) NOT NULL DEFAULT 0,
  `is_preppy` tinyint(4)  NOT NULL DEFAULT 0,
  `is_handsome` tinyint(4) NOT NULL DEFAULT 0,
  `is_punk` tinyint(4) NOT NULL DEFAULT 0,
  `is_bf` tinyint(4) NOT NULL DEFAULT 0,
  `is_classic` tinyint(4) NOT NULL DEFAULT 0,
  `is_art` tinyint(4) NOT NULL DEFAULT 0,
  `is_morigirl` tinyint(4) NOT NULL DEFAULT 0,
  `is_commute` tinyint(4) NOT NULL DEFAULT 0,
  `is_sport` tinyint(4) NOT NULL DEFAULT 0,
  `time` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `mix`;
CREATE TABLE `mix` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL DEFAULT 0,
  `top` int(10) NOT NULL DEFAULT 0,
  `bottom` int(10) NOT NULL DEFAULT 0,
  `shoe` int(10) NOT NULL DEFAULT 0,
  `bag` int(10) NOT NULL DEFAULT 0,
  `ornament` int(10) NOT NULL DEFAULT 0,
  `understanding` VARCHAR(2048) NOT NULL DEFAULT '',
  `occasion` int(10) NOT NULL DEFAULT 0,
  `style` int(10) NOT NULL DEFAULT 0,
  `feeling` int(10) NOT NULL DEFAULT 0,
  `time` int(10) NOT NULL DEFAULT 0,
  `for_date` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `style`;
CREATE TABLE `style` (
  `code` tinyint(4) NOT NULL DEFAULT 0 COMMENT '递增Id',
  `style` VARCHAR(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into style values(11,'甜美');
insert into style values(12,'轻熟');
insert into style values(13,'学院');
insert into style values(21,'帅气');
insert into style values(22,'朋克');
insert into style values(23,'BF');
insert into style values(31,'复古');
insert into style values(32,'文艺');
insert into style values(33,'森女');
insert into style values(41,'通勤');
insert into style values(42,'运动');


DROP TABLE IF EXISTS `color`;
CREATE TABLE `color` (
  `code` tinyint(4) NOT NULL DEFAULT 0 COMMENT '递增Id',
  `color` VARCHAR(128) NOT NULL DEFAULT '',
  `RGB` VARCHAR(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
insert into color values(10,'正红','');
insert into color values(11,'浅红','');
insert into color values(12,'深红','');
insert into color values(20,'正澄','');
insert into color values(21,'浅澄','');
insert into color values(22,'深澄','');
insert into color values(30,'正黄','');
insert into color values(31,'浅黄','');
insert into color values(32,'深黄','');
insert into color values(40,'正绿','');
insert into color values(41,'浅绿','');
insert into color values(42,'深绿','');
insert into color values(50,'正蓝','');
insert into color values(51,'浅蓝','');
insert into color values(52,'深蓝','');
insert into color values(60,'正紫','');
insert into color values(61,'浅紫','');
insert into color values(62,'深紫','');
insert into color values(70,'黑','');
insert into color values(80,'白','');
insert into color values(90,'正灰','');
insert into color values(91,'浅灰','');
insert into color values(92,'深灰','');
insert into color values(100,'银','');
insert into color values(110,'金','');
insert into color values(120,'正粉','');
insert into color values(121,'浅粉','');
insert into color values(122,'深粉','');
insert into color values(130,'肉粉','');
insert into color values(140,'正杏','');
insert into color values(141,'浅杏','');
insert into color values(142,'深杏','');

DROP TABLE IF EXISTS `cloth_type`;
CREATE TABLE `cloth_type` (
  `id` int(10) NOT NULL,
  `type` VARCHAR(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO cloth_type values(1,'上装');
INSERT INTO cloth_type values(2,'下装');
INSERT INTO cloth_type values(3,'鞋');
INSERT INTO cloth_type values(4,'包');
INSERT INTO cloth_type values(5,'饰品');

DROP TABLE IF EXISTS `cloth_sub_type`;
CREATE TABLE `cloth_sub_type` (
  `id` int(10) NOT NULL  comment 'Id',
  `type_id` int(10) NOT NULL DEFAULT 0,
  `type` VARCHAR(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO cloth_sub_type values(11,1,'常规');
INSERT INTO cloth_sub_type values(12,1,'连身');
INSERT INTO cloth_sub_type values(21,2,'裤子');
INSERT INTO cloth_sub_type values(22,2,'短裤');
INSERT INTO cloth_sub_type values(31,3,'单鞋');
INSERT INTO cloth_sub_type values(32,3,'平底鞋');
INSERT INTO cloth_sub_type values(33,3,'凉鞋');
INSERT INTO cloth_sub_type values(34,3,'跟鞋');
INSERT INTO cloth_sub_type values(35,3,'靴子');
INSERT INTO cloth_sub_type values(41,4,'单肩');
INSERT INTO cloth_sub_type values(42,4,'双肩');
INSERT INTO cloth_sub_type values(43,4,'斜跨');
INSERT INTO cloth_sub_type values(44,4,'手拿');
INSERT INTO cloth_sub_type values(51,5,'头饰');
INSERT INTO cloth_sub_type values(52,5,'颈饰');
INSERT INTO cloth_sub_type values(53,5,'耳饰');
INSERT INTO cloth_sub_type values(54,5,'手饰');
INSERT INTO cloth_sub_type values(55,5,'其他');


-- DROP TABLE IF EXISTS `user_collect`;
-- CREATE TABLE `user_collect` (
--   `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
--   `user_id` int(10) NOT NULL COMMENT '被关注人ID',
--   `good_id` int(10) NOT NULL Comment '收藏商品Id',
--   `is_delete` tinyint(10) NOT NULL DEFAULT 0,
--   PRIMARY KEY (`id`),
--   INDEX `index_user_id` (`user_id`),
--   INDEX `index_follower_id` (`follower_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 评论表 包括单品评论 、搭配评论