CREATE TABLE IF NOT EXISTS `t_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户UID',
  `nick` varchar(72) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户昵称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户类型 1：微信用户 2：QQ用户',
  `fromact` int(11) NOT NULL DEFAULT '0' COMMENT '用户来源的活动ID',
  `uin` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户uin QQ用户：QQ号码 微信用户：微信openid',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态 1正常用户 2黑名单',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '积分数量',
  `actcount` int(11) NOT NULL DEFAULT '0' COMMENT '参与活动数量',
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '姓名',
  `tel` varchar(11) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '手机号',
  `telother` tinyint(1) NOT NULL DEFAULT '2' COMMENT '是否有其他手机号 1是 2否',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '入库时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `type` (`type`,`uin`),
  KEY `fromact` (`fromact`),
  KEY `status` (`status`),
  KEY `tel` (`tel`),
  KEY `telother` (`telother`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户表' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `t_content` (
  `contentid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `uin` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户uin QQ用户：QQ号码 微信用户：微信openid',
  `nick` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '报料标题，24个汉字限制',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '报料内容',
  `images` varchar(3000) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '图片列表',
  `video` varchar(150) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '视频地址',
  `videoout` varchar(150) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '视频输出地址',
  `examine` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态 0未审核 1审核通过 2审核不通过',
  `reason` varchar(360) COLLATE utf8_unicode_ci DEFAULT '' COMMENT ' 审核不通过的原因',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0待处理 1已回复 2已处理',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '报料时间',
  `recount` int(11) NOT NULL DEFAULT '0' COMMENT '回复数量',
  `viewcount` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数量',
  `showstatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示状态 1普通 2隐藏',
  PRIMARY KEY (`contentid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='报料表' AUTO_INCREMENT=1 ;