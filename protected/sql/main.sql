DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `time` int(10) NOT NULL COMMENT '创建时间',
  user_name char(255) NOT NULL default "" unique,
  nick_name char(255) NOT NULL default "",
  passwd char(255) NOT NULL default "" comment "登录密码",
  mobile char(255) NOT NULL unique default "" comment "手机号",
  email varchar(255) NOT NULL unique default "",
  wx_access_token VARCHAR(255) NOT NULL DEFAULT "",
  PRIMARY KEY (`id`),
  INDEX `index_user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * 用户
 */
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL default 0 COMMENT '用户ID',
  `stature` char(10) NOT NULL default "" COMMENT '身高 传递float值',
  `weight` char(10) NOT NULL  default "" COMMENT '体重 传递float值',
  `feature` tinyint(4) NOT NULL default 0 COMMENT '脸型 1曲线形 2中间形 3直线形',
  `somatotype` tinyint(4) NOT NULL default 0 COMMENT '体型 1沙漏 2V型 3梨子 4H 5S',
  `complexion` tinyint(4) NOT NULL default 0 COMMENT '肤色 1白 2偏白略黄 3黄 4偏黑',
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `clothing`;
CREATE TABLE `clothing` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * 衣橱
 */
DROP TABLE IF EXISTS `closet`;
CREATE TABLE `closet` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '递增Id',
  `user_id` int(10) NOT NULL default 0 COMMENT '用户ID',
  `time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




