
-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` BIGINT(20) PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  `username` VARCHAR(60) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `phone` VARCHAR(32),
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `sex` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '性别  0：未知  1：男 2：女 3：其他',
  `realname` VARCHAR(45)  COMMENT '真实姓名',
  `contact_address` VARCHAR(45)  COMMENT '联系地址',
  `inviter_id` BIGINT(20) NOT NULL DEFAULT 0 COMMENT '邀请人ID',
  INDEX `index_email` (`email` ASC)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '用户表,这里指的是临床医生';


-- -----------------------------------------------------
-- Table `project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS  `project` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL COMMENT '标题',
  `status` TINYINT(2) NOT NULL DEFAULT 0 COMMENT '项目状态',
  `content` TEXT comment '项目详细介绍',
  `type` TINYINT(2) NOT NULL DEFAULT 1 COMMENT '项目类型',
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `update_time` INT(10) NOT NULL DEFAULT 0,
  `owner_id` BIGINT(20) NOT NULL COMMENT '所有者ID',
  `max_member_num` INT(10) NOT NULL DEFAULT 100 COMMENT '最大成员数'.
  key(`owner_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '项目表';


-- -----------------------------------------------------
-- Table `project_member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS  `project_member` (
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `project_id` BIGINT(20) NOT NULL,
  `user_id` BIGINT(20) NOT NULL COMMENT '成员ID',
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  `type` TINYINT(2) NOT NULL DEFAULT 0 COMMENT '类型, 0：创建者 1:主研, 2:参研',
  `name` VARCHAR(45) COMMENT '成员项目名称',
  `inviter_id` INT(20) NOT NULL DEFAULT 0 COMMENT '	',
  `invite_time` INT(10) NOT NULL DEFAULT 0,
  `accept_time` INT(10) NOT NULL DEFAULT 0,
  key(`project_id`),
  key(`user_id`),
  key(`inviter_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '项目成员表';


-- -----------------------------------------------------
-- Table `organization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `organization` (
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  `parent_id` INT(10) NOT NULL DEFAULT 0,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  key(`parent_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '组织 医院科室表';



-- -----------------------------------------------------
-- Table `user_organization`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_organization` (
  `organization_id` INT(10) NOT NULL,
  `user_id` INT(20) NOT NULL,
  `status` TINYINT(2) NOT NULL default 0 comment '状态',
  `position` TINYINT(2) NOT NULL default 0 comment '职位',
  PRIMARY KEY (`organization_id`, `user_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin comment = '用户-组织 关系表' ;


-- -----------------------------------------------------
-- Table `topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `topic` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `content` TEXT,
  `project_id` BIGINT(20) NOT NULL,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `update_time` INT(10) NOT NULL,
  `owner_id` BIGINT(20) NOT NULL,
  key(`owner_id`),
  key(`project_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '话题/讨论表';


-- -----------------------------------------------------
-- Table `topic_discuss`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `topic_discuss` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` BIGINT(20) NOT NULL,
  `content` TEXT comment '内容',
  `topic_id` BIGINT(10) NOT NULL,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `update_time` INT(10) NOT NULL DEFAULT 0,
  key(`user_id`),
  key(`topic_id`)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '讨论';


-- -----------------------------------------------------
-- Table `attachment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `attachment` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `user_id` BIGINT(20) NOT NULL,
  `path` VARCHAR(200) NOT NULL COMMENT '相对存储路径',
  `url` VARCHAR(300) NOT NULL COMMENT '下载链接',
  `size` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT '附件大小, 单位M',
  `project_id` BIGINT(20) NOT NULL DEFAULT 0,
  `topic_id` BIGINT(20) NOT NULL DEFAULT 0,
  `discuss_id` BIGINT(20) NOT NULL DEFAULT 0,
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  key(`user_id`),
  key(`project_id`),
  key(`topic_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '附件';


-- -----------------------------------------------------
-- Table `form`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `form_format` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `title` VARCHAR(100) NOT NULL comment '标题',
  `data_fomat` TEXT comment '格式定义，预计是json',
  `status` TINYINT(2) NOT NULL DEFAULT 0,
  `update_time` INT(10) NOT NULL DEFAULT 0,
  `project_id` BIGINT(20) NOT NULL,
  `create_user_id` BIGINT(20) NOT NULL,
  key(`project_id`)
 ) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '问卷信息格式表';


-- -----------------------------------------------------
-- Table `patient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `patient` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(16) NOT NULL,
  `email` VARCHAR(255),
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `phone` VARCHAR(32),
  `status` TINYINT(20) NOT NULL DEFAULT 0,
  `project_id` BIGINT(20) NOT NULL,
  `create_user_id` BIGINT(20) NOT NULL DEFAULT 0,
  `id_card` VARCHAR(60)  COMMENT '身份证',
  `update_time` INT(10) NOT NULL DEFAULT 0,
  `age` SMALLINT(3) DEFAULT 0 COMMENT '年龄',
  `birthday` int(10) not NULL default 0 COMMENT '出生日期',
  `sex` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '性别: 0:未知 1:男性  2:女性 3:其他',
  `comment` VARCHAR(200) NULL COMMENT '备注',
  key(`project_id`),
  key(`create_user_id`)
)  ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '患者表';





-- -----------------------------------------------------
-- Table `log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `log` (
  `id` BIGINT(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `table_name` VARCHAR(200) NOT NULL,
  `table_id` BIGINT(20) NOT NULL,
  `old_data` VARCHAR(500) NULL,
  `update_data` VARCHAR(500) NULL,
  `type` TINYINT(2) NOT NULL DEFAULT 1 COMMENT '类型 1:更新, 2:创建',
  `actor_id` BIGINT(20) NOT NULL COMMENT '操作人ID',
  `actor_type` TINYINT(2) NOT NULL DEFAULT 1 COMMENT '操作人类型 1:user'
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '通用重要数据日志表';



-- -----------------------------------------------------
-- Table `user_limit`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_limit` (
  `user_id` VARCHAR(16) NOT NULL,
  `normal_pro_num` INT(10) NOT NULL DEFAULT 100 comment '普通项目上限',
  `one_center_pro_num` INT(10) NOT NULL DEFAULT 1 comment '单中心项目上限',
  PRIMARY KEY (`user_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '用户限制表';


-- -----------------------------------------------------
-- Table `invite`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `invite` (
  `id` BIGINT(20) PRIMARY KEY NOT NULL,
  `inviter_id` BIGINT(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `invitee_id` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `validate_code` VARCHAR(50) NOT NULL comment '邀请码 验证用',
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `project_id` BIGINT(20) NOT NULL DEFAULT 0 comment '邀请项目ID',
  key(`invitee_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT = '邀请表';

-- -----------------------------------------------------
-- Table `form_data_`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `form_data_` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `create_time` INT(10) NOT NULL DEFAULT 0,
  `create_user_id` BIGINT(20) NOT NULL DEFAULT 0,
  `patient_id` BIGINT(20) NOT NULL,
  `update_time` INT(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
COMMENT = '表单数据,不同的表单将生成不同的数据';
