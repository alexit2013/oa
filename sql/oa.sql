/*
 Source Database       : oa

 Target Server Type    : MySQL
 Target Server Version : 100209
 File Encoding         : utf-8

 Date: 12/19/2017 13:47:40 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `think_contact`
-- ----------------------------
DROP TABLE IF EXISTS `think_contact`;
CREATE TABLE `think_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `letter` varchar(50) NOT NULL DEFAULT '' COMMENT '拼音',
  `company` varchar(30) NOT NULL DEFAULT '' COMMENT '公司',
  `dept` varchar(20) NOT NULL DEFAULT '' COMMENT '部门',
  `position` varchar(20) NOT NULL DEFAULT '' COMMENT '职位',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件',
  `office_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '办公电话',
  `mobile_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '移动电话',
  `website` varchar(50) NOT NULL DEFAULT '' COMMENT '网站',
  `im` varchar(20) NOT NULL DEFAULT '' COMMENT '即时通讯',
  `address` varchar(50) NOT NULL DEFAULT '' COMMENT '地址',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `remark` text DEFAULT NULL COMMENT '备注',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='think_user_info';

-- ----------------------------
--  Table structure for `think_customer`
-- ----------------------------
DROP TABLE IF EXISTS `think_customer`;
CREATE TABLE `think_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `letter` varchar(50) NOT NULL DEFAULT '' COMMENT '拼音',
  `biz_license` varchar(30) NOT NULL DEFAULT '' COMMENT '营业许可',
  `short` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `contact` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件地址',
  `office_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '办公电话',
  `mobile_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '移动电话',
  `fax` varchar(20) NOT NULL DEFAULT '' COMMENT '传真',
  `salesman` varchar(50) NOT NULL DEFAULT '' COMMENT '业务员',
  `im` varchar(20) NOT NULL DEFAULT '' COMMENT '即时通讯',
  `address` varchar(50) NOT NULL DEFAULT '' COMMENT '地址',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `remark` text DEFAULT NULL COMMENT '备注',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `payment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_demo`
-- ----------------------------
DROP TABLE IF EXISTS `think_demo`;
CREATE TABLE `think_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_dept`
-- ----------------------------
DROP TABLE IF EXISTS `think_dept`;
CREATE TABLE `think_dept` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL,
  `DEPT_NO` varchar(20) NOT NULL,
  `DEPT_GRADE_ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `SHORT` varchar(20) NOT NULL,
  `SORT` int(11) NOT NULL,
  `REMARK` varchar(255) NOT NULL,
  `IS_DEL` tinyint(3) NOT NULL,
  `kpi_is_del` int(1) NOT NULL DEFAULT 0 COMMENT 'kpi系统门店禁用（1，禁用，0，启用）',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=494 DEFAULT CHARSET=utf8 COMMENT='组织机构';

-- ----------------------------
--  Table structure for `think_dept_grade`
-- ----------------------------
DROP TABLE IF EXISTS `think_dept_grade`;
CREATE TABLE `think_dept_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_no` varchar(10) NOT NULL DEFAULT '' COMMENT '部门级别编码',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='组织机构分级';

-- ----------------------------
--  Table structure for `think_doc`
-- ----------------------------
DROP TABLE IF EXISTS `think_doc`;
CREATE TABLE `think_doc` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) NOT NULL DEFAULT '' COMMENT '文档编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text NOT NULL COMMENT '内容',
  `folder` int(11) NOT NULL DEFAULT 0 COMMENT '文件夹',
  `add_file` varchar(200) NOT NULL DEFAULT '' COMMENT '附件',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_duty`
-- ----------------------------
DROP TABLE IF EXISTS `think_duty`;
CREATE TABLE `think_duty` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `duty_no` varchar(20) NOT NULL DEFAULT '' COMMENT '职责编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(20) NOT NULL DEFAULT '' COMMENT '排序',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='业务角色(流程的权限)';

-- ----------------------------
--  Table structure for `think_file`
-- ----------------------------
DROP TABLE IF EXISTS `think_file`;
CREATE TABLE `think_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '文件保存位置',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '远程地址',
  `create_time` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11477 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
--  Table structure for `think_finance`
-- ----------------------------
DROP TABLE IF EXISTS `think_finance`;
CREATE TABLE `think_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(10) DEFAULT NULL COMMENT '单据编号',
  `remark` varchar(255) DEFAULT NULL,
  `input_date` date DEFAULT NULL COMMENT '录入日期',
  `account_id` int(11) DEFAULT NULL COMMENT '帐号ID',
  `account_name` varchar(20) DEFAULT NULL COMMENT '帐号名',
  `income` int(11) DEFAULT NULL COMMENT '收入',
  `payment` int(11) DEFAULT NULL COMMENT '支出',
  `amount` int(11) DEFAULT NULL COMMENT '合计',
  `type` varchar(20) DEFAULT NULL COMMENT '类型',
  `partner` varchar(50) DEFAULT NULL COMMENT '来往处',
  `actor_name` varchar(10) DEFAULT NULL COMMENT '经办人',
  `user_id` int(11) DEFAULT NULL COMMENT '登陆人',
  `user_name` varchar(10) DEFAULT NULL COMMENT '登录名',
  `create_time` int(11) DEFAULT NULL COMMENT '创建日期',
  `update_time` int(11) DEFAULT NULL COMMENT '更新日期',
  `add_file` varchar(255) DEFAULT NULL COMMENT '附件',
  `doc_type` tinyint(3) DEFAULT NULL COMMENT '类型',
  `is_del` tinyint(3) DEFAULT 0 COMMENT '删除标记',
  `related_account_id` int(11) DEFAULT NULL COMMENT '相关帐号ID',
  `related_account_name` varchar(20) DEFAULT NULL COMMENT '相关帐号名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_finance_account`
-- ----------------------------
DROP TABLE IF EXISTS `think_finance_account`;
CREATE TABLE `think_finance_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '帐号名称',
  `bank` varchar(20) DEFAULT NULL COMMENT '银行',
  `no` varchar(50) DEFAULT NULL COMMENT '银行帐号',
  `init` int(11) DEFAULT NULL COMMENT '初始帐号',
  `balance` int(11) DEFAULT NULL COMMENT '余额',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `is_del` tinyint(3) DEFAULT 0 COMMENT '删除标记',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_flow`
-- ----------------------------
DROP TABLE IF EXISTS `think_flow`;
CREATE TABLE `think_flow` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '文档编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text DEFAULT NULL COMMENT '内容',
  `confirm` text DEFAULT NULL COMMENT '裁决数据',
  `confirm_name` text DEFAULT NULL COMMENT '裁决显示内容',
  `consult` varchar(200) DEFAULT '' COMMENT '协商数据',
  `consult_name` text DEFAULT NULL COMMENT '协商显示内容',
  `refer` varchar(200) DEFAULT '' COMMENT '抄送数据',
  `refer_name` text DEFAULT NULL COMMENT '抄送显示内容',
  `type` varchar(20) DEFAULT '' COMMENT '流程类型',
  `add_file` varchar(200) DEFAULT '' COMMENT '附件',
  `user_id` int(11) DEFAULT 0 COMMENT '用户ID',
  `emp_no` varchar(20) DEFAULT NULL COMMENT '员工编号',
  `user_name` varchar(20) DEFAULT '' COMMENT '用户名称',
  `dept_id` int(11) DEFAULT 0 COMMENT '部门ID',
  `dept_name` varchar(20) DEFAULT '' COMMENT '部门名称',
  `create_date` varchar(10) DEFAULT '' COMMENT '创建日期',
  `create_time` int(11) unsigned DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned DEFAULT 0 COMMENT '更新时间',
  `step` int(11) DEFAULT 0 COMMENT '目前阶段状态',
  `is_del` tinyint(3) DEFAULT 0 COMMENT '删除标记',
  `udf_data` text DEFAULT NULL COMMENT '用户自定义数据',
  `pos_type` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39593 DEFAULT CHARSET=utf8 COMMENT='审批流程明细';

-- ----------------------------
--  Table structure for `think_flow_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_flow_log`;
CREATE TABLE `think_flow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL DEFAULT 0 COMMENT '流程ID',
  `emp_no` varchar(20) NOT NULL DEFAULT '' COMMENT '员工编号',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `user_name` varchar(20) DEFAULT '' COMMENT '用户名称',
  `step` int(11) NOT NULL DEFAULT 0 COMMENT '当前步骤',
  `result` int(11) DEFAULT NULL COMMENT '审批结果',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `comment` text DEFAULT NULL COMMENT '意见',
  `is_read` tinyint(3) NOT NULL DEFAULT 0 COMMENT '已读',
  `from` varchar(20) DEFAULT NULL COMMENT '传阅人',
  `is_del` tinyint(3) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97891 DEFAULT CHARSET=utf8 COMMENT='流程审批人/审批状态明细';

-- ----------------------------
--  Table structure for `think_flow_suggestion`
-- ----------------------------
DROP TABLE IF EXISTS `think_flow_suggestion`;
CREATE TABLE `think_flow_suggestion` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(20) NOT NULL DEFAULT '' COMMENT '账号',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '意见人名称',
  `flow_id` int(11) NOT NULL COMMENT '流程id',
  `flow_log_id` int(11) NOT NULL COMMENT '对应flow_log中id',
  `question` varchar(100) DEFAULT NULL COMMENT '意见问题',
  `comment` varchar(200) DEFAULT NULL COMMENT '意见',
  `create_time` varchar(11) NOT NULL COMMENT '创建时间',
  `write_time` varchar(11) DEFAULT NULL COMMENT '填写意见日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='流程审批询问意见';

-- ----------------------------
--  Table structure for `think_flow_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_flow_type`;
CREATE TABLE `think_flow_type` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '分组',
  `doc_no_format` varchar(50) NOT NULL DEFAULT '' COMMENT '文档编码格式',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `short` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `content` text NOT NULL COMMENT '内容',
  `confirm` text NOT NULL COMMENT '裁决数据',
  `confirm_name` text NOT NULL COMMENT '裁决显示内容',
  `consult` varchar(100) NOT NULL DEFAULT '' COMMENT '协商数据',
  `consult_name` text NOT NULL COMMENT '协商显示内容',
  `refer` varchar(100) NOT NULL DEFAULT '' COMMENT '抄送数据',
  `refer_name` text NOT NULL COMMENT '抄送显示内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` smallint(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `is_edit` tinyint(3) NOT NULL DEFAULT 0 COMMENT '可编辑标记',
  `is_lock` tinyint(3) NOT NULL DEFAULT 0 COMMENT '锁定标记',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `request_duty` int(11) DEFAULT NULL COMMENT '申请权限',
  `report_duty` int(11) DEFAULT NULL COMMENT '报告权限',
  `udf_tpl` varchar(20) DEFAULT NULL,
  `is_show` tinyint(3) DEFAULT NULL,
  `type` int(11) DEFAULT 0 COMMENT '流程类型：0、oa审批流程；1.异常考勤；2.加班申请；3.调休申请；4.请假申请；5.公出申请；6.出差申请；',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='流程类型';

-- ----------------------------
--  Table structure for `think_flow_type_copy0914`
-- ----------------------------
DROP TABLE IF EXISTS `think_flow_type_copy0914`;
CREATE TABLE `think_flow_type_copy0914` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '分组',
  `doc_no_format` varchar(50) NOT NULL DEFAULT '' COMMENT '文档编码格式',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `short` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `content` text NOT NULL COMMENT '内容',
  `confirm` text NOT NULL COMMENT '裁决数据',
  `confirm_name` text NOT NULL COMMENT '裁决显示内容',
  `consult` varchar(100) NOT NULL DEFAULT '' COMMENT '协商数据',
  `consult_name` text NOT NULL COMMENT '协商显示内容',
  `refer` varchar(100) NOT NULL DEFAULT '' COMMENT '抄送数据',
  `refer_name` text NOT NULL COMMENT '抄送显示内容',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` smallint(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `is_edit` tinyint(3) NOT NULL DEFAULT 0 COMMENT '可编辑标记',
  `is_lock` tinyint(3) NOT NULL DEFAULT 0 COMMENT '锁定标记',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `request_duty` int(11) DEFAULT NULL COMMENT '申请权限',
  `report_duty` int(11) DEFAULT NULL COMMENT '报告权限',
  `udf_tpl` varchar(20) DEFAULT NULL,
  `is_show` tinyint(3) DEFAULT NULL,
  `type` int(11) DEFAULT 0 COMMENT '流程类型：0、oa审批流程；1.异常考勤；2.加班申请；3.调休申请；4.请假申请；5.公出申请；6.出差申请；',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='流程类型';

-- ----------------------------
--  Table structure for `think_form`
-- ----------------------------
DROP TABLE IF EXISTS `think_form`;
CREATE TABLE `think_form` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) NOT NULL DEFAULT '' COMMENT '文档编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text NOT NULL COMMENT '内容',
  `folder` int(11) NOT NULL DEFAULT 0 COMMENT '文件夹',
  `add_file` varchar(200) NOT NULL DEFAULT '' COMMENT '附件',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `udf_data` text DEFAULT NULL COMMENT '自定义字段数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_group`
-- ----------------------------
DROP TABLE IF EXISTS `think_group`;
CREATE TABLE `think_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `is_public` tinyint(3) DEFAULT NULL COMMENT '是否公开',
  `remark` text DEFAULT NULL COMMENT '备注',
  `user_id` int(11) DEFAULT NULL COMMENT '登陆人ID',
  `user_name` varchar(20) DEFAULT NULL COMMENT '登录用户名称',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `sort` varchar(10) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_group_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_group_user`;
CREATE TABLE `think_group_user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_info`
-- ----------------------------
DROP TABLE IF EXISTS `think_info`;
CREATE TABLE `think_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) NOT NULL DEFAULT '' COMMENT '文档编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text NOT NULL COMMENT '内容',
  `folder` int(11) NOT NULL DEFAULT 0 COMMENT '分类',
  `is_sign` tinyint(3) DEFAULT 0 COMMENT '是否需要签收',
  `is_public` tinyint(3) DEFAULT NULL COMMENT '是否公开',
  `scope_user_id` text DEFAULT NULL COMMENT '发布范围ID',
  `scope_user_name` text DEFAULT NULL COMMENT '发布范围名称',
  `add_file` varchar(200) NOT NULL DEFAULT '' COMMENT '附件',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '登陆人ID',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '登陆人名称',
  `dept_id` int(11) DEFAULT NULL COMMENT '部门ID',
  `dept_name` varchar(20) DEFAULT NULL COMMENT '部门名称',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='信息明细(发文)';

-- ----------------------------
--  Table structure for `think_info_scope`
-- ----------------------------
DROP TABLE IF EXISTS `think_info_scope`;
CREATE TABLE `think_info_scope` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `info_id` (`info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_info_sign`
-- ----------------------------
DROP TABLE IF EXISTS `think_info_sign`;
CREATE TABLE `think_info_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_id` int(11) NOT NULL DEFAULT 0 COMMENT '信息ID',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '登录用户ID',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '登录用户名称',
  `is_sign` tinyint(3) NOT NULL DEFAULT 0 COMMENT '是否签收',
  `sign_time` int(11) unsigned DEFAULT NULL COMMENT '签收时间',
  `dept_id` int(11) DEFAULT NULL COMMENT '部门ID',
  `dept_name` varchar(20) DEFAULT NULL COMMENT '部门名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_kpi_account`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_account`;
CREATE TABLE `think_kpi_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '明细',
  `store_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_id` int(7) NOT NULL COMMENT '科目类别ID',
  `three_m` decimal(12,2) DEFAULT NULL COMMENT '3个月以内',
  `fourtosix_m` decimal(12,2) DEFAULT NULL COMMENT '4-6月',
  `seventotwelve_m` decimal(12,2) DEFAULT NULL COMMENT '7-12月',
  `onetotwo_y` decimal(12,2) DEFAULT NULL COMMENT '1年以上',
  `two_y` decimal(12,2) DEFAULT NULL COMMENT '2年以上',
  `three_y` decimal(12,2) DEFAULT NULL COMMENT '3年以上',
  `mark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1232 DEFAULT CHARSET=utf8 COMMENT='应收账款账龄表';

-- ----------------------------
--  Table structure for `think_kpi_account_class`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_account_class`;
CREATE TABLE `think_kpi_account_class` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '应收账款名称',
  `pid` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='[基础数据]应收账款科目类型表';

-- ----------------------------
--  Table structure for `think_kpi_carbrand`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carbrand`;
CREATE TABLE `think_kpi_carbrand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '车品牌表id',
  `carbrand_name` varchar(20) DEFAULT NULL COMMENT '车品牌名称',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销（0：否，1：是）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='[基础数据]品牌表';

-- ----------------------------
--  Table structure for `think_kpi_carfee_financedrive`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_financedrive`;
CREATE TABLE `think_kpi_carfee_financedrive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `finance_carnum` varchar(15) NOT NULL COMMENT '财务账面车牌号',
  `finance_buycartime` int(11) NOT NULL COMMENT '财务账面购车日期',
  `actual_carnum` varchar(15) NOT NULL COMMENT '实际车辆车牌号',
  `finance_price` decimal(12,2) NOT NULL COMMENT '财务帐面处置价格',
  `actual_price` decimal(12,2) NOT NULL COMMENT '实际车辆处置价格',
  `actual_buycartime` int(11) NOT NULL COMMENT '实际车辆购入日期',
  `use` varchar(30) NOT NULL COMMENT '使用情况',
  `difference` varchar(200) NOT NULL COMMENT '差异原因',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店财务帐面用车和实际车辆情况';

-- ----------------------------
--  Table structure for `think_kpi_carfee_saledrive`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_saledrive`;
CREATE TABLE `think_kpi_carfee_saledrive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carnum` varchar(100) NOT NULL COMMENT '车牌号',
  `buycartime` int(11) NOT NULL COMMENT '购车日期',
  `naked` decimal(12,2) NOT NULL COMMENT '裸车价',
  `price` decimal(12,2) NOT NULL COMMENT '购入价格',
  `discount` decimal(12,2) NOT NULL COMMENT '折扣率',
  `plate` decimal(12,2) NOT NULL COMMENT '挂牌价格',
  `saleprice` decimal(12,2) NOT NULL COMMENT '销售价格',
  `remark` varchar(100) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店销售未使用试乘试驾车表';

-- ----------------------------
--  Table structure for `think_kpi_carfee_selfdrive`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_selfdrive`;
CREATE TABLE `think_kpi_carfee_selfdrive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carnum` varchar(100) NOT NULL COMMENT '车牌号',
  `buycartime` int(11) NOT NULL COMMENT '购车日期',
  `naked` decimal(12,2) NOT NULL COMMENT '裸车价',
  `price` decimal(12,2) NOT NULL COMMENT '购入价格',
  `discount` decimal(12,2) NOT NULL COMMENT '折扣率',
  `mileage` decimal(9,2) NOT NULL COMMENT '累计里程数',
  `month_mileage` decimal(9,2) NOT NULL COMMENT '本月里程数',
  `user` varchar(30) NOT NULL COMMENT '使用部门或个人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店自备经营用车';

-- ----------------------------
--  Table structure for `think_kpi_carfee_specialdrive`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_specialdrive`;
CREATE TABLE `think_kpi_carfee_specialdrive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carnum` varchar(100) NOT NULL COMMENT '车牌号',
  `buycartime` int(11) NOT NULL COMMENT '购车日期',
  `naked` decimal(12,2) NOT NULL COMMENT '裸车价',
  `price` decimal(12,2) NOT NULL COMMENT '购入价格',
  `discount` decimal(12,2) NOT NULL COMMENT '折扣率',
  `mileage` decimal(9,2) NOT NULL COMMENT '累计里程数',
  `month_mileage` decimal(9,2) NOT NULL COMMENT '本月里程数',
  `user` varchar(30) NOT NULL COMMENT '使用部门或个人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店特殊车辆使用情况';

-- ----------------------------
--  Table structure for `think_kpi_carfee_testdrive`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_testdrive`;
CREATE TABLE `think_kpi_carfee_testdrive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carnum` varchar(100) NOT NULL COMMENT '车牌号',
  `buycartime` int(11) NOT NULL COMMENT '购车日期',
  `naked` decimal(12,2) NOT NULL COMMENT '裸车市场价',
  `price` decimal(12,2) NOT NULL COMMENT '购入价格',
  `discount` decimal(12,2) NOT NULL COMMENT '折扣率',
  `plate` decimal(12,2) NOT NULL COMMENT '挂牌价格',
  `mileage` int(9) NOT NULL COMMENT '累计公里数(单位千米)',
  `enddate` int(11) NOT NULL,
  `is_mana` int(1) NOT NULL COMMENT '近期是否处置1是0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店自用试乘试驾车';

-- ----------------------------
--  Table structure for `think_kpi_carfee_vehicleuse`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carfee_vehicleuse`;
CREATE TABLE `think_kpi_carfee_vehicleuse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carnum` varchar(100) NOT NULL COMMENT '车牌号',
  `buycartime` int(11) NOT NULL COMMENT '购车日期',
  `naked` decimal(12,2) NOT NULL COMMENT '裸车市场价',
  `price` decimal(12,2) NOT NULL COMMENT '购入价格',
  `discount` decimal(12,2) NOT NULL COMMENT '折扣率',
  `plate` decimal(12,2) NOT NULL COMMENT '挂牌价格',
  `mileage` int(9) NOT NULL COMMENT '累计公里数(单位千米)',
  `enddate` int(11) NOT NULL,
  `is_mana` int(1) NOT NULL COMMENT '近期是否处置1是0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='车辆费用表-4S店使用中(借用)试乘试驾车';

-- ----------------------------
--  Table structure for `think_kpi_carprofit`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carprofit`;
CREATE TABLE `think_kpi_carprofit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `carbrand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `carseries_id` int(8) unsigned DEFAULT NULL COMMENT '车系id',
  `carsize_id` int(11) unsigned DEFAULT NULL COMMENT '车型id',
  `cash_transfer` decimal(12,2) DEFAULT 0.00 COMMENT '现金转让(元)',
  `expect_sales` int(8) DEFAULT 0 COMMENT '预计销售台次(俩)',
  `qzjj` decimal(12,2) DEFAULT 0.00 COMMENT '前装加价金额',
  `qzcb` decimal(12,2) DEFAULT 0.00 COMMENT '前装成本金额',
  `zslb` decimal(12,2) DEFAULT 0.00 COMMENT '赠送礼包',
  `zscb` decimal(12,2) DEFAULT 0.00 COMMENT '赠送成本金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=334 DEFAULT CHARSET=utf8 COMMENT='整车毛利测算表';

-- ----------------------------
--  Table structure for `think_kpi_carseries`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carseries`;
CREATE TABLE `think_kpi_carseries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车系id',
  `carseries_name` varchar(30) DEFAULT NULL COMMENT '车系名称',
  `is_import` int(2) unsigned DEFAULT NULL COMMENT '是否是进口（1：国产，2：进口）',
  `carbrand_id` int(11) unsigned DEFAULT NULL COMMENT '品牌id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='[基础数据]车系表';

-- ----------------------------
--  Table structure for `think_kpi_carseries_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carseries_copy`;
CREATE TABLE `think_kpi_carseries_copy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车系id',
  `carseries_name` varchar(30) DEFAULT NULL COMMENT '车系名称',
  `is_import` int(2) unsigned DEFAULT NULL COMMENT '是否是进口（1：国产，2：进口）',
  `carbrand_id` int(11) unsigned DEFAULT NULL COMMENT '品牌id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COMMENT='[基础数据]车系表';

-- ----------------------------
--  Table structure for `think_kpi_carseriesposage`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carseriesposage`;
CREATE TABLE `think_kpi_carseriesposage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `carbrand_id` int(11) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carsize_id` int(11) DEFAULT NULL,
  `three_num` int(7) NOT NULL COMMENT '3月以内数量',
  `three_price` decimal(12,2) NOT NULL COMMENT '3月以内单价',
  `three_prices` decimal(12,2) NOT NULL COMMENT '3月以内金额',
  `threetosix_num` int(7) NOT NULL COMMENT '3-6月以内数量',
  `threetosix_price` decimal(12,2) NOT NULL COMMENT '3-6月以内单价',
  `threetosix_prices` decimal(12,2) NOT NULL COMMENT '3-6月以内金额',
  `sixtotwelve_num` int(7) NOT NULL COMMENT '6-12月以内数量',
  `sixtotwelve_price` decimal(12,2) NOT NULL COMMENT '6-12月以内单价',
  `sixtotwelve_prices` decimal(12,2) NOT NULL COMMENT '6-12月以内金额',
  `year_num` int(7) NOT NULL COMMENT '一年以上数量',
  `year_price` decimal(12,2) NOT NULL COMMENT '一年以上单价',
  `year_prices` decimal(12,2) NOT NULL COMMENT '一年以上金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8 COMMENT='车系库龄表';

-- ----------------------------
--  Table structure for `think_kpi_carseriesposage_adjust`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carseriesposage_adjust`;
CREATE TABLE `think_kpi_carseriesposage_adjust` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `name` varchar(30) NOT NULL COMMENT '项目',
  `number` decimal(12,2) NOT NULL COMMENT '数量',
  `money` decimal(12,2) NOT NULL COMMENT '金额',
  `type` int(1) NOT NULL COMMENT '类型：1.财务数据 ，2.业务数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='车型库龄表-调节表(已禁用）';

-- ----------------------------
--  Table structure for `think_kpi_carseriesposage_way`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carseriesposage_way`;
CREATE TABLE `think_kpi_carseriesposage_way` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `store_id` int(11) NOT NULL,
  `finance_vin` varchar(40) DEFAULT NULL COMMENT '财务在途-车架号',
  `finance_carseries_id` int(11) DEFAULT NULL COMMENT '财务在途-车系',
  `finance_price` decimal(12,2) DEFAULT NULL COMMENT '财务在途-不含税采购价',
  `sale_vin` varchar(40) DEFAULT NULL COMMENT '销售部KPI做销售-车架号',
  `sale_carseries_id` int(11) DEFAULT NULL COMMENT '销售部KPI-车系',
  `sale_price` decimal(12,2) DEFAULT NULL COMMENT '销售部KPI-不含税采购价',
  `pay_vin` varchar(40) DEFAULT NULL COMMENT '已付款出门未收到发票-车架号',
  `pay_carseries_id` int(11) DEFAULT NULL COMMENT '已付款出门未收到发票-车系',
  `pay_price` decimal(12,2) DEFAULT NULL COMMENT '已付款出门未收到发票-不含税采购价',
  `month` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='车系库龄表--在途';

-- ----------------------------
--  Table structure for `think_kpi_carsize`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carsize`;
CREATE TABLE `think_kpi_carsize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车型表id',
  `carsize_name` varchar(30) DEFAULT NULL COMMENT '车型名称',
  `carseries_id` int(8) unsigned DEFAULT NULL COMMENT '车系id',
  `add_time` varchar(12) DEFAULT NULL COMMENT '创建时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销',
  `guide_price` decimal(12,2) DEFAULT NULL COMMENT '厂家指导价格',
  `invoice_price` decimal(12,2) DEFAULT NULL COMMENT '厂家开票进货价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=520 DEFAULT CHARSET=utf8 COMMENT='[基础数据]-车型表';

-- ----------------------------
--  Table structure for `think_kpi_carsize_copy1`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_carsize_copy1`;
CREATE TABLE `think_kpi_carsize_copy1` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车型表id',
  `carsize_name` varchar(30) DEFAULT NULL COMMENT '车型名称',
  `carseries_id` int(8) unsigned DEFAULT NULL COMMENT '车系id',
  `add_time` varchar(12) DEFAULT NULL COMMENT '创建时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销',
  `guide_price` decimal(12,2) DEFAULT NULL COMMENT '厂家指导价格',
  `invoice_price` decimal(12,2) DEFAULT NULL COMMENT '厂家开票进货价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=519 DEFAULT CHARSET=utf8 COMMENT='[基础数据]-车型表';

-- ----------------------------
--  Table structure for `think_kpi_chart_dept_flow`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_chart_dept_flow`;
CREATE TABLE `think_kpi_chart_dept_flow` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `dept_id` text DEFAULT NULL COMMENT '发起部门,例如：部门1,部门2,部门3',
  `emp_no` text DEFAULT NULL COMMENT '发起人账号，例如：账号1,账号2,账号3',
  `chart_type_id` int(5) DEFAULT NULL COMMENT '报表id',
  `flow_type_id` int(5) DEFAULT NULL COMMENT 'kpi流程ID',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='KPI各部门报表关联流程类型表';

-- ----------------------------
--  Table structure for `think_kpi_chart_deptclass`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_chart_deptclass`;
CREATE TABLE `think_kpi_chart_deptclass` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `pid` int(5) DEFAULT NULL,
  `chart_type_id` int(3) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `biao` int(2) DEFAULT NULL COMMENT '微信跳转链接序号（$biao）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='报表对应各部门类别 [基础数据]';

-- ----------------------------
--  Table structure for `think_kpi_chart_deptstatus`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_chart_deptstatus`;
CREATE TABLE `think_kpi_chart_deptstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL COMMENT '部门id',
  `flow_id` int(11) NOT NULL COMMENT '流程id',
  `chart_deptclass_id` int(3) NOT NULL COMMENT 'think_kpi_chart_deptclass表ID',
  `chart_type_id` int(3) NOT NULL COMMENT 'think_kpi_chart_deptclass表部门类别ID',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '审批情况 0审批中，1通过，2退回',
  `emp_no` varchar(40) DEFAULT NULL COMMENT '账号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8 COMMENT='各部门类别报表审批情况(审批状态表)';

-- ----------------------------
--  Table structure for `think_kpi_chart_status`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_chart_status`;
CREATE TABLE `think_kpi_chart_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `chart_deptclass_id` int(3) NOT NULL COMMENT 'think_kpi_chart_deptclass表ID',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '审批情况 1通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COMMENT='管理报表状态';

-- ----------------------------
--  Table structure for `think_kpi_chart_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_chart_type`;
CREATE TABLE `think_kpi_chart_type` (
  `id` int(3) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL COMMENT '名称',
  `controller_name` varchar(30) DEFAULT NULL COMMENT '控制器名',
  `type` int(1) DEFAULT NULL COMMENT '部门类型',
  `tables` text DEFAULT NULL COMMENT '数据表'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门报表（报表对应部门类型和数据表）[基础数据]';

-- ----------------------------
--  Table structure for `think_kpi_com`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_com`;
CREATE TABLE `think_kpi_com` (
  `emp_no` varchar(50) NOT NULL COMMENT '账号',
  `com_ids` varchar(100) DEFAULT NULL COMMENT '门店IDs',
  PRIMARY KEY (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='kpi用户管理多公司';

-- ----------------------------
--  Table structure for `think_kpi_config`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_config`;
CREATE TABLE `think_kpi_config` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `value` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Kpi配置表  [基础数据]';

-- ----------------------------
--  Table structure for `think_kpi_costbudget`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_costbudget`;
CREATE TABLE `think_kpi_costbudget` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '职工薪酬表ID',
  `store_id` int(3) DEFAULT NULL COMMENT '门店ID',
  `year` int(4) unsigned DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `project_id` int(8) unsigned DEFAULT NULL COMMENT '项目id(对应think_kpi_costbudget_project表id)',
  `pm_expect` float(12,2) DEFAULT NULL COMMENT '上月工资预测',
  `pm_actual` float(12,2) DEFAULT NULL COMMENT '上月工资实际',
  `tm_expect` float(12,2) DEFAULT NULL COMMENT '本月（预测）',
  `tm_salesDept_expect` float(12,2) DEFAULT NULL COMMENT '销售部（预测）',
  `tm_repairDept_expect` float(12,2) DEFAULT NULL COMMENT '维修部（预测）',
  `tm_ornDept_expect` float(12,2) DEFAULT NULL COMMENT '装潢部（预测）',
  `tm_adminDept_expect` float(12,2) DEFAULT NULL COMMENT '行政部（预测）',
  `tm_financeDept_expect` float(12,2) DEFAULT NULL COMMENT '财务部（预测）',
  `tm_gmDept_expect` float(12,2) DEFAULT NULL COMMENT '总经理（预测）',
  `tm_serviceDept_expect` float(12,2) DEFAULT NULL COMMENT '客服部（预测）',
  `tm_market_expect` float(12,2) DEFAULT NULL COMMENT '市场部（预测）',
  `tm_other_expect` float(12,2) DEFAULT NULL COMMENT '其他（预测）',
  `remark` varchar(20) DEFAULT NULL COMMENT '备注',
  `add_time` int(11) DEFAULT NULL COMMENT '录入时间',
  `1_ppm_actual` float(12,2) DEFAULT NULL COMMENT '1-上上月实际',
  `1_tm_expect` float(12,2) DEFAULT NULL COMMENT '1-本月预算',
  `classify_id` varchar(4) DEFAULT NULL COMMENT '对应添加的区块id（1-4）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=861 DEFAULT CHARSET=utf8 COMMENT='费用预算';

-- ----------------------------
--  Table structure for `think_kpi_costbudget_project`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_costbudget_project`;
CREATE TABLE `think_kpi_costbudget_project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `project_pid` int(3) DEFAULT NULL COMMENT '项目父ID',
  `project_name` varchar(30) DEFAULT NULL COMMENT '项目名称',
  `is_del` int(1) DEFAULT 0 COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COMMENT='[基础数据]费用预算-项目名称表';

-- ----------------------------
--  Table structure for `think_kpi_flow`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_flow`;
CREATE TABLE `think_kpi_flow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flow_name` varchar(30) NOT NULL,
  `emp_no` varchar(30) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `confirm` varchar(250) NOT NULL,
  `refer` varchar(250) NOT NULL,
  `content` varchar(250) NOT NULL,
  `flow_type` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `steps` int(2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `chart` varchar(30) DEFAULT NULL,
  `chart_type_id` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_kpi_flow_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_flow_log`;
CREATE TABLE `think_kpi_flow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL COMMENT '发起流程id',
  `name` varchar(30) NOT NULL COMMENT '姓名',
  `emp_no` varchar(30) NOT NULL COMMENT '账号',
  `status` int(1) DEFAULT NULL COMMENT '是否通过：1通过，2退回,  3待提交',
  `step` int(2) NOT NULL COMMENT '审批步骤',
  `step_pos` int(2) DEFAULT NULL COMMENT '审批节点',
  `content` varchar(50) DEFAULT NULL COMMENT '审批意见',
  `is_del` smallint(1) DEFAULT 0,
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=886 DEFAULT CHARSET=utf8 COMMENT='审批流程节点表';

-- ----------------------------
--  Table structure for `think_kpi_flow_refer`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_flow_refer`;
CREATE TABLE `think_kpi_flow_refer` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `flow_id` int(11) DEFAULT NULL,
  `emp_no` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='kpi抄送表';

-- ----------------------------
--  Table structure for `think_kpi_flow_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_flow_type`;
CREATE TABLE `think_kpi_flow_type` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `confirm` text NOT NULL COMMENT '审批节点，例如：节点1|节点2|节点3',
  `refer` varchar(100) NOT NULL DEFAULT '' COMMENT '抄送人员，例：抄送节点1|抄送节点2|抄送节点3',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` smallint(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='KPI审批流程配置';

-- ----------------------------
--  Table structure for `think_kpi_flow_type_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_flow_type_copy`;
CREATE TABLE `think_kpi_flow_type_copy` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `confirm` text NOT NULL COMMENT '审批节点，例如：节点1|节点2|节点3',
  `refer` varchar(100) NOT NULL DEFAULT '' COMMENT '抄送人员，例：抄送节点1|抄送节点2|抄送节点3',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` smallint(3) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='KPI审批流程配置';

-- ----------------------------
--  Table structure for `think_kpi_inventory_variance`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_inventory_variance`;
CREATE TABLE `think_kpi_inventory_variance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `store_id` int(11) NOT NULL,
  `financial_inventory` int(11) NOT NULL COMMENT '财务库存',
  `sales_inventory` int(11) NOT NULL COMMENT '销售库存',
  `difference` int(11) NOT NULL COMMENT '差异',
  `remarks` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='车型库龄表--差异数据';

-- ----------------------------
--  Table structure for `think_kpi_market`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_market`;
CREATE TABLE `think_kpi_market` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(5) NOT NULL COMMENT '市场营销预算类型',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年份',
  `month` int(2) NOT NULL,
  `plan_y` decimal(12,2) DEFAULT NULL COMMENT '年度计划',
  `pay_y` decimal(12,2) DEFAULT NULL COMMENT '累计支出',
  `plan_m` decimal(12,2) DEFAULT NULL COMMENT '本月计划',
  `pay_m` decimal(12,2) DEFAULT NULL COMMENT '主机厂支出',
  `mark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COMMENT='本月市场营销费用预算';

-- ----------------------------
--  Table structure for `think_kpi_market_custom`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_market_custom`;
CREATE TABLE `think_kpi_market_custom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年份',
  `month` int(2) NOT NULL,
  `sale_one` int(7) DEFAULT NULL COMMENT '销售目标',
  `sale_two` int(7) DEFAULT NULL COMMENT '本月二级销售目标',
  `deal_y` decimal(6,2) DEFAULT NULL COMMENT '本月计划',
  `deal_gh` decimal(6,2) DEFAULT NULL COMMENT '广汇平均成交率',
  `file_y` decimal(6,2) DEFAULT NULL COMMENT '本年平均留档率',
  `file_gh` decimal(6,2) DEFAULT NULL COMMENT '广汇平均留档率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='本月市场营销费用预算';

-- ----------------------------
--  Table structure for `think_kpi_market_customlast`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_market_customlast`;
CREATE TABLE `think_kpi_market_customlast` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(5) NOT NULL COMMENT '市场营销预算类型',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年份',
  `month` int(2) NOT NULL,
  `file` int(9) NOT NULL COMMENT '上月实投',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='本月市场营销费用预算上月回顾客户来源';

-- ----------------------------
--  Table structure for `think_kpi_market_last`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_market_last`;
CREATE TABLE `think_kpi_market_last` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(5) NOT NULL COMMENT '市场营销预算类型',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年份',
  `month` int(2) NOT NULL,
  `investment` decimal(12,2) DEFAULT NULL COMMENT '上月实投',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='本月市场营销费用预算上月回顾市场费用流向';

-- ----------------------------
--  Table structure for `think_kpi_market_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_market_type`;
CREATE TABLE `think_kpi_market_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL COMMENT '市场营销预算',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='[基础数据]市场营销费用预算类型';

-- ----------------------------
--  Table structure for `think_kpi_marketdegree`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_marketdegree`;
CREATE TABLE `think_kpi_marketdegree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `manufacturer_target` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT '厂家目标',
  `actual_reach` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT '实际达成',
  `ssi_tel_score` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'ssi-电话-得分',
  `ssi_tel_regionrank` int(9) NOT NULL DEFAULT 0 COMMENT 'ssi-电话-分区排名',
  `ssi_tel_countryrank` int(9) NOT NULL DEFAULT 0 COMMENT 'ssi-电话-全国排名',
  `ssi_mystery_score` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'ssi-神秘客-得分',
  `ssi_mystery_regionrank` int(9) NOT NULL DEFAULT 0 COMMENT 'ssi-神秘客-分区排名',
  `ssi_mystery_countryrank` int(9) NOT NULL DEFAULT 0 COMMENT 'ssi-神秘客-全国排名',
  `csi_tel_score` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'csi-电话-得分',
  `csi_tel_regionrank` int(9) NOT NULL DEFAULT 0 COMMENT 'csi-电话-分区排名',
  `csi_tel_countryrank` int(9) NOT NULL DEFAULT 0 COMMENT 'ssi-电话-全国排名',
  `csi_mystery_score` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'csi-神秘客-得分',
  `csi_mystery_regionrank` int(9) NOT NULL DEFAULT 0 COMMENT 'csi-神秘客-分区排名',
  `csi_mystery_countryrank` int(9) NOT NULL DEFAULT 0 COMMENT 'csi-神秘客-全国排名',
  `mystery_sale` int(9) NOT NULL DEFAULT 0 COMMENT '销售得分',
  `mystery_after` int(9) NOT NULL DEFAULT 0 COMMENT '售后得分',
  `quality` int(9) NOT NULL DEFAULT 0 COMMENT '数据质量',
  `spq` int(9) NOT NULL DEFAULT 0 COMMENT 'spq',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COMMENT='市占率与满意度';

-- ----------------------------
--  Table structure for `think_kpi_month_carloan`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_carloan`;
CREATE TABLE `think_kpi_month_carloan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_income_last` decimal(12,2) DEFAULT 0.00 COMMENT '预测佣金收入',
  `actual_income_last` decimal(12,2) DEFAULT 0.00 COMMENT '实际佣金收入',
  `expect_margin` decimal(12,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(12,2) DEFAULT 0.00 COMMENT '实际毛利',
  `cost` decimal(12,2) DEFAULT 0.00 COMMENT '成本',
  `income` decimal(12,2) DEFAULT 0.00 COMMENT '佣金收入',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-车贷业务';

-- ----------------------------
--  Table structure for `think_kpi_month_carprofit`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_carprofit`;
CREATE TABLE `think_kpi_month_carprofit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `carbrand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `carseries_id` int(8) unsigned DEFAULT NULL COMMENT '车系id',
  `expect_num` int(8) DEFAULT 0 COMMENT '预计台次(俩)',
  `actual_num` int(11) DEFAULT 0 COMMENT '实际台数',
  `expect_margin` decimal(12,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(12,2) DEFAULT 0.00 COMMENT '实际毛利',
  `expect_marginprofit` decimal(5,2) DEFAULT 0.00 COMMENT '预测毛利率',
  `actual_marginprofit` decimal(5,2) DEFAULT 0.00 COMMENT '实际毛利率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-月销售正常毛利预测';

-- ----------------------------
--  Table structure for `think_kpi_month_carprofit_piao`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_carprofit_piao`;
CREATE TABLE `think_kpi_month_carprofit_piao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `expect_num` int(8) DEFAULT 0 COMMENT '上月预计台次(俩)',
  `actual_num` int(11) DEFAULT 0 COMMENT '上月实际台数',
  `expect_margin` decimal(12,2) DEFAULT 0.00 COMMENT '上月预测毛利',
  `actual_margin` decimal(12,2) DEFAULT 0.00 COMMENT '上月实际毛利',
  `expect_marginprofit` decimal(6,2) DEFAULT 0.00 COMMENT '上月预测毛利率',
  `actual_marginprofit` decimal(6,2) DEFAULT 0.00 COMMENT '上月实际毛利率',
  `tm_sale_num` int(9) DEFAULT 0 COMMENT '本月销售台次',
  `tm_price` decimal(12,2) DEFAULT 0.00 COMMENT '本月进价合计',
  `tm_sale_price` decimal(12,2) DEFAULT 0.00 COMMENT '本月销价合计',
  `tm_margin` decimal(12,2) DEFAULT 0.00 COMMENT '本月毛利',
  `tm_marginprofit` decimal(5,2) DEFAULT 0.00 COMMENT '本月毛利率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-月销售正常毛利预测-虚开票';

-- ----------------------------
--  Table structure for `think_kpi_month_decorate_class`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_decorate_class`;
CREATE TABLE `think_kpi_month_decorate_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `class_name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `expect_income` decimal(12,2) DEFAULT 0.00 COMMENT '预计收入',
  `actual_income` decimal(12,2) DEFAULT 0.00 COMMENT '实际收入',
  `expect_margin` decimal(12,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(12,2) DEFAULT 0.00 COMMENT '实际毛利',
  `cost` decimal(12,2) DEFAULT 0.00 COMMENT '成本',
  `income` decimal(12,2) DEFAULT 0.00 COMMENT '收入',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-装饰业务-分类';

-- ----------------------------
--  Table structure for `think_kpi_month_decorate_emphasis`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_decorate_emphasis`;
CREATE TABLE `think_kpi_month_decorate_emphasis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `class_name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `average` decimal(9,2) DEFAULT 0.00 COMMENT '同品牌平均渗透率',
  `store` decimal(9,2) DEFAULT 0.00 COMMENT '店面渗透率目标',
  `actual` decimal(9,2) DEFAULT 0.00,
  `store_actual` decimal(9,2) DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-装饰业务-重点产品';

-- ----------------------------
--  Table structure for `think_kpi_month_decorate_focus`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_decorate_focus`;
CREATE TABLE `think_kpi_month_decorate_focus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `target` decimal(9,2) DEFAULT 0.00 COMMENT '目标',
  `actual` decimal(9,2) DEFAULT 0.00 COMMENT '实际',
  `target2` decimal(9,2) DEFAULT 0.00 COMMENT '目标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-装饰业务-集中采购额度';

-- ----------------------------
--  Table structure for `think_kpi_month_insurance`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_insurance`;
CREATE TABLE `think_kpi_month_insurance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_num_last` int(8) DEFAULT 0 COMMENT '预计台次(俩)',
  `actual_num_last` int(11) DEFAULT 0 COMMENT '实际台数',
  `expect_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '预测佣金收入',
  `actual_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '实际佣金收入',
  `expect_num` int(5) DEFAULT 0 COMMENT '本月预测台次',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '人工成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-新保业务';

-- ----------------------------
--  Table structure for `think_kpi_month_insurance_target`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_insurance_target`;
CREATE TABLE `think_kpi_month_insurance_target` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `average` decimal(9,2) DEFAULT 0.00 COMMENT '同品牌平均渗透率',
  `store` decimal(9,2) DEFAULT 0.00 COMMENT '店面渗透率',
  `actual` decimal(9,2) DEFAULT 0.00 COMMENT '实际渗透率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-新保渗透率目标';

-- ----------------------------
--  Table structure for `think_kpi_month_mortgage_num`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_mortgage_num`;
CREATE TABLE `think_kpi_month_mortgage_num` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) DEFAULT NULL,
  `forecast_last` decimal(9,2) DEFAULT 0.00 COMMENT '上月预测',
  `actual_last` decimal(9,2) DEFAULT 0.00 COMMENT '上月实际',
  `forecast_report_profit` decimal(9,2) DEFAULT 0.00 COMMENT '预测管理报表利润',
  `actual_report_profit` decimal(9,2) DEFAULT 0.00 COMMENT '实际管理报表利润',
  `forecast_this` decimal(9,2) DEFAULT 0.00 COMMENT '本月预测',
  `poundage` decimal(9,2) DEFAULT 0.00 COMMENT '手续费客单价（万元）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-车贷业务-厂家金融及银行按揭台次';

-- ----------------------------
--  Table structure for `think_kpi_month_newcar`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_newcar`;
CREATE TABLE `think_kpi_month_newcar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_num_last` int(8) DEFAULT 0 COMMENT '预计台次(俩)',
  `actual_num_last` int(11) DEFAULT 0 COMMENT '实际台数',
  `expect_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '预测佣金收入',
  `actual_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '实际佣金收入',
  `expect_num` int(5) DEFAULT 0 COMMENT '本月预测台次',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '人工成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  `expect_margin` decimal(9,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(9,2) DEFAULT 0.00 COMMENT '实际毛利',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-新车延保';

-- ----------------------------
--  Table structure for `think_kpi_month_non_newcar`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_non_newcar`;
CREATE TABLE `think_kpi_month_non_newcar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_num` int(7) DEFAULT 0 COMMENT '预测台次',
  `actual_num` int(7) DEFAULT 0 COMMENT '实际台次',
  `expect_income` decimal(9,2) DEFAULT 0.00 COMMENT '预测佣金收入',
  `actual_income` decimal(9,2) DEFAULT 0.00 COMMENT '实际佣金收入',
  `expect_carnum` int(7) DEFAULT 0 COMMENT '预测台次2',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '本月人工成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  `expect_margin` decimal(9,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(9,2) DEFAULT 0.00 COMMENT '实际毛利',
  `new_car_sales` decimal(9,2) DEFAULT 0.00 COMMENT '上一年同期展厅新车销量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-非新车延保';

-- ----------------------------
--  Table structure for `think_kpi_month_other`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_other`;
CREATE TABLE `think_kpi_month_other` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_num_last` int(7) DEFAULT 0 COMMENT '预计台次(俩)',
  `actual_num_last` int(7) DEFAULT 0 COMMENT '实际台数',
  `expect_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '预测收入',
  `actual_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '实际收入',
  `change_num` int(7) DEFAULT 0 COMMENT '置换台次',
  `sale_num` int(7) DEFAULT 0 COMMENT '销售台次',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '销售成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '销售收入',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-其他业务';

-- ----------------------------
--  Table structure for `think_kpi_month_other_cost`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_other_cost`;
CREATE TABLE `think_kpi_month_other_cost` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `forecast_last` decimal(9,2) DEFAULT 0.00 COMMENT '上月预测毛利',
  `actual_last` decimal(9,2) DEFAULT 0.00 COMMENT '上月实际毛利',
  `forecast_this` decimal(9,2) DEFAULT 0.00 COMMENT '本月预测销售成本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-其他业务->人工成本';

-- ----------------------------
--  Table structure for `think_kpi_month_penetrance`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_penetrance`;
CREATE TABLE `think_kpi_month_penetrance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `class_name` varchar(20) DEFAULT NULL COMMENT '分类名称',
  `average` decimal(9,2) DEFAULT 0.00 COMMENT '同品牌平均渗透率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-续保业务-续保渗透率目标';

-- ----------------------------
--  Table structure for `think_kpi_month_renewal`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_renewal`;
CREATE TABLE `think_kpi_month_renewal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_num` int(7) DEFAULT 0 COMMENT '预测台次',
  `actual_num` int(7) DEFAULT 0 COMMENT '实际台次',
  `expect_income` decimal(9,2) DEFAULT 0.00 COMMENT '预测佣金收入',
  `actual_income` decimal(9,2) DEFAULT 0.00 COMMENT '实际佣金收入',
  `expect_carnum` int(7) DEFAULT 0 COMMENT '预测台次2',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '本月成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  `expect_margin` decimal(9,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(9,2) DEFAULT 0.00 COMMENT '实际毛利',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-续保业务';

-- ----------------------------
--  Table structure for `think_kpi_month_repair`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_repair`;
CREATE TABLE `think_kpi_month_repair` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '预测收入',
  `actual_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '实际收入',
  `expect_margin` decimal(9,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(9,2) DEFAULT 0.00 COMMENT '实际毛利',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  `repair_num` int(7) DEFAULT 0 COMMENT '维修台次',
  `type` int(1) DEFAULT 0 COMMENT '分类: 0默认，1配件，2其他',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-维修业务';

-- ----------------------------
--  Table structure for `think_kpi_month_repair_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_repair_copy`;
CREATE TABLE `think_kpi_month_repair_copy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '整车毛利测算',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `class_name` varchar(30) NOT NULL,
  `expect_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '预测收入',
  `actual_income_last` decimal(9,2) DEFAULT 0.00 COMMENT '实际收入',
  `expect_margin` decimal(9,2) DEFAULT 0.00 COMMENT '预测毛利',
  `actual_margin` decimal(9,2) DEFAULT 0.00 COMMENT '实际毛利',
  `cost` decimal(9,2) DEFAULT 0.00 COMMENT '成本',
  `income` decimal(9,2) DEFAULT 0.00 COMMENT '佣金收入',
  `repair_num` int(7) DEFAULT 0 COMMENT '维修台次',
  `type` int(1) DEFAULT 0 COMMENT '分类: 0默认，1配件，2其他',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-维修业务';

-- ----------------------------
--  Table structure for `think_kpi_month_three_card_business`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_month_three_card_business`;
CREATE TABLE `think_kpi_month_three_card_business` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `month` int(2) DEFAULT NULL,
  `class_name` varchar(30) DEFAULT NULL,
  `expect_num_last` int(8) DEFAULT 0 COMMENT '上月预测数量',
  `actual_num_last` int(8) DEFAULT 0 COMMENT '上月实际数量',
  `expect_num_this` int(8) DEFAULT 0 COMMENT '本月预测数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='月毛利率预算表-三卡业务';

-- ----------------------------
--  Table structure for `think_kpi_mvasname`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_mvasname`;
CREATE TABLE `think_kpi_mvasname` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点增值业务指标（增值业务名称表）',
  `MVAS_name` varchar(30) DEFAULT NULL COMMENT '名称',
  `is_del` int(1) DEFAULT 0 COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='[基础数据] 售后重点增值业务指标（类型名称表）';

-- ----------------------------
--  Table structure for `think_kpi_pri`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_pri`;
CREATE TABLE `think_kpi_pri` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '功能名称',
  `pid` int(5) NOT NULL COMMENT '上级功能id',
  `module_name` varchar(30) DEFAULT NULL,
  `controller_name` varchar(30) DEFAULT NULL,
  `action_name` varchar(30) DEFAULT NULL,
  `rank` int(5) DEFAULT NULL COMMENT '排序',
  `isadd` int(1) NOT NULL DEFAULT 0 COMMENT '是否为添加按钮',
  `ischart` int(1) DEFAULT 0 COMMENT '是否为报表：0否、1是',
  `icon` varchar(20) NOT NULL COMMENT '图标',
  `type` int(1) DEFAULT NULL COMMENT '页面类型：1.销售部、2.售后部、3.市场部、4.财务部、5、客服部、6.行政部、7.金融部、8.保险部、9.装饰部',
  `chart_type_id` int(11) DEFAULT NULL COMMENT 'think_kpi_chart_type的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=469 DEFAULT CHARSET=utf8 COMMENT='[基础数据]权限表';

-- ----------------------------
--  Table structure for `think_kpi_profitbudget`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_profitbudget`;
CREATE TABLE `think_kpi_profitbudget` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(4) DEFAULT NULL COMMENT '门店ID',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `project_id` int(3) unsigned DEFAULT NULL COMMENT '利润预算项目ID（对应think_kpi_profitbudget_project的id）',
  `pm_actualNum` decimal(12,2) DEFAULT NULL COMMENT '上月实际数',
  `pm_expectAmount` decimal(12,2) DEFAULT NULL COMMENT '上月计划金额',
  `pm_budgetAmount` decimal(12,2) DEFAULT NULL COMMENT '月预算金额（上月）',
  `tm_expectAmount` decimal(12,2) DEFAULT 0.00 COMMENT '本月计划金额',
  `tm_budgetAmount` decimal(12,2) DEFAULT NULL COMMENT '预算金额（本月）',
  `ro_1_ppm_actual` decimal(12,2) DEFAULT NULL COMMENT '1-上上月实际（滚动预测数）',
  `ro_1_tmtot_budget` decimal(12,2) DEFAULT NULL COMMENT '1-本月累计预算（滚动预测数）',
  `ro_ty_budget` decimal(12,2) DEFAULT NULL COMMENT '本年预算',
  `remark` varchar(20) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=utf8 COMMENT='利润预算表';

-- ----------------------------
--  Table structure for `think_kpi_profitbudget_project`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_profitbudget_project`;
CREATE TABLE `think_kpi_profitbudget_project` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '利润预算表项目名称ID',
  `project_pid` int(6) unsigned DEFAULT NULL COMMENT '父ID',
  `project_name` varchar(30) DEFAULT NULL COMMENT '预算项目名称',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否删除',
  `sort` int(5) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='[基础数据]利润预算表-项目名称';

-- ----------------------------
--  Table structure for `think_kpi_rebate`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebate`;
CREATE TABLE `think_kpi_rebate` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '返利计算基础表1',
  `store_id` int(4) unsigned NOT NULL COMMENT '门店id',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `type` int(1) DEFAULT NULL COMMENT '类型（1，实际，2，预计）',
  `carbrand_id` int(4) unsigned DEFAULT NULL COMMENT '品牌ID',
  `carsize_id` int(6) DEFAULT NULL COMMENT '车型id',
  `carseries_id` int(6) DEFAULT NULL COMMENT '车系配置id',
  `sales_num` int(108) DEFAULT NULL COMMENT '销售（台次）',
  `marketprice` decimal(12,2) DEFAULT NULL COMMENT '市场指导价',
  `batchprice` decimal(12,2) DEFAULT NULL COMMENT '批售价',
  `into_seling_diffprice` decimal(12,2) DEFAULT NULL COMMENT '进售差价',
  `is_del` int(1) DEFAULT 0 COMMENT '0：正常，1：异常',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1235 DEFAULT CHARSET=utf8 COMMENT='返利计算表';

-- ----------------------------
--  Table structure for `think_kpi_rebate_des`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebate_des`;
CREATE TABLE `think_kpi_rebate_des` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(3) DEFAULT NULL,
  `store_id` int(6) DEFAULT NULL COMMENT '门店id',
  `type` int(1) DEFAULT NULL COMMENT '类型（1.实际，2.预计)',
  `s_rebate` decimal(12,2) DEFAULT NULL COMMENT '当期预估市场推广返利',
  `m_rebate` decimal(12,2) DEFAULT NULL COMMENT '当期满意度类预估返利',
  `j_rebate` decimal(12,2) DEFAULT NULL COMMENT '日常检查类返利',
  `d_rebate` decimal(12,2) DEFAULT NULL COMMENT '大客户类型返利',
  `dq_rebate` decimal(12,2) DEFAULT NULL COMMENT '当期其他类返利',
  `q_rebate` decimal(12,2) DEFAULT NULL COMMENT '前期未预估的补估返利',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='返利计算表-预估返利明细表';

-- ----------------------------
--  Table structure for `think_kpi_rebate_quarter`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebate_quarter`;
CREATE TABLE `think_kpi_rebate_quarter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(3) DEFAULT NULL COMMENT '门店ID',
  `year` int(4) DEFAULT NULL COMMENT '年度',
  `carbrand_id` int(5) NOT NULL COMMENT '品牌ID',
  `carseries_id` int(5) NOT NULL COMMENT '车系',
  `carsize_id` int(5) NOT NULL COMMENT '车型',
  `quarter` varchar(100) DEFAULT NULL COMMENT '季度',
  `rebate_name` varchar(100) NOT NULL COMMENT '返利名称',
  `rebate_val` float(8,2) NOT NULL COMMENT '返利值',
  `month` int(2) DEFAULT NULL COMMENT '月份',
  `spend_type` int(1) NOT NULL COMMENT '1(年度)，2（季度），3（门店独属[年度，季度]）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 COMMENT='[基础数据]返利（年度，季度）';

-- ----------------------------
--  Table structure for `think_kpi_rebatename`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebatename`;
CREATE TABLE `think_kpi_rebatename` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '返利基础（除外税）',
  `rebate_name` varchar(100) DEFAULT NULL COMMENT '返利名称',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是都删除（0，否，1，是）',
  `carbrand_id` int(3) DEFAULT NULL COMMENT '品牌ID',
  `store_id` int(3) DEFAULT NULL COMMENT '门店',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8 COMMENT='[基础数据]返利名称表';

-- ----------------------------
--  Table structure for `think_kpi_rebatename_copy0917`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebatename_copy0917`;
CREATE TABLE `think_kpi_rebatename_copy0917` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '返利基础（除外税）',
  `rebate_name` varchar(100) DEFAULT NULL COMMENT '返利名称',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是都删除（0，否，1，是）',
  `carbrand_id` int(3) DEFAULT NULL COMMENT '品牌ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='返利名称表[基础数据]';

-- ----------------------------
--  Table structure for `think_kpi_rebatename_val`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_rebatename_val`;
CREATE TABLE `think_kpi_rebatename_val` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '返利（处税）',
  `rebate_id` int(6) DEFAULT NULL COMMENT '返利计算表id（对应think_kpi_rebate表id）',
  `rebate_name_id` int(6) DEFAULT NULL COMMENT '返利名称ID（对应think_kpi_rebatename表id）',
  `rebate_name` varchar(120) DEFAULT NULL COMMENT '返利名称',
  `rebate_val` decimal(12,2) DEFAULT NULL COMMENT '返利值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2533 DEFAULT CHARSET=utf8 COMMENT='返利计算表关联返利值表';

-- ----------------------------
--  Table structure for `think_kpi_refer_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_refer_type`;
CREATE TABLE `think_kpi_refer_type` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `deptclass_id` int(3) unsigned NOT NULL COMMENT 'think_kpi_chart_daptclass表ID',
  `refer` text NOT NULL COMMENT '抄送',
  `sort` int(3) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_kpi_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_role`;
CREATE TABLE `think_kpi_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色表id',
  `name` varchar(100) NOT NULL COMMENT '角色名称',
  `pri_ids` text DEFAULT NULL COMMENT '权限id',
  `rank` int(3) DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='[基础数据]角色表';

-- ----------------------------
--  Table structure for `think_kpi_runrate`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_runrate`;
CREATE TABLE `think_kpi_runrate` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点经营指标（占比表）',
  `num_premonth_yoy` float(6,2) DEFAULT NULL COMMENT '台次上月同比',
  `num_premonth_chain` float(6,2) DEFAULT NULL COMMENT '台次上月环比',
  `num_thatyear_total` int(6) DEFAULT NULL COMMENT '台次当年累计',
  `num_total_chain` float(6,2) DEFAULT NULL COMMENT '台次累计同比',
  `guestprice_premonth_yoy` float(6,2) DEFAULT NULL COMMENT '客单价上月同比',
  `guestprice_premonth_chain` float(6,2) DEFAULT NULL COMMENT '客单价上月环比',
  `guestprice_thatyear_total` int(6) DEFAULT NULL COMMENT '客单价当年累计',
  `guestprice_total_chain` float(6,2) DEFAULT NULL COMMENT '台次累计同比',
  `output_premonth_yoy` float(6,2) DEFAULT NULL COMMENT '产值上月同比',
  `output_premonth_chain` float(6,2) DEFAULT NULL COMMENT '产值上月环比',
  `output_thatyear_total` int(6) DEFAULT NULL COMMENT '产值当月累计',
  `output_total_chain` float(6,2) DEFAULT NULL COMMENT '产值累计同比',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `numrate_premonth_yoy` float(6,2) DEFAULT NULL COMMENT '台次占比上月同比',
  `numrate_premonth_chain` float(6,2) DEFAULT NULL COMMENT '台次占比上月环比',
  `numrate_thatyear_total` float(6,2) DEFAULT NULL COMMENT '台次占比当年累计',
  `numrate_total_chain` float(6,2) DEFAULT NULL COMMENT '台次占比累计同比',
  `outputrate_premonth_yoy` float(6,2) DEFAULT NULL COMMENT '产值占比上月同比',
  `outputrate_premonth_chain` float(6,2) DEFAULT NULL COMMENT '产值占比上月环比',
  `outputrate_thatyear_total` float(6,2) DEFAULT NULL COMMENT '产值占比当年累计',
  `outputrate_total_chain` float(6,2) DEFAULT NULL COMMENT '产值占比累计同比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='售后重点经营指标（占比表）';

-- ----------------------------
--  Table structure for `think_kpi_runtarget`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_runtarget`;
CREATE TABLE `think_kpi_runtarget` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点经营指标（上月）ID',
  `type_id` int(2) unsigned DEFAULT NULL COMMENT '经营指标名称id(对应think_kpi_runtargettype表id)',
  `expect_sellnum` int(6) DEFAULT NULL COMMENT '预计销售台次',
  `actual_sellnum` int(6) unsigned DEFAULT NULL COMMENT '实际销售台次',
  `expect_guestprice` float(8,2) DEFAULT NULL COMMENT '预计客单价',
  `actual_guestprice` float(8,2) DEFAULT NULL COMMENT '实际客单件',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `add_time` int(11) DEFAULT NULL COMMENT '录入时间',
  `thatmonth_expext_sellnum` int(6) DEFAULT NULL COMMENT '本月预测销售台次',
  `thatmonth_expect_guestprice` float(8,2) DEFAULT NULL COMMENT '本月预测客单价',
  `store_id` int(3) unsigned DEFAULT NULL COMMENT '门店ID',
  `other_sellnum` int(6) DEFAULT NULL COMMENT '类型为其他销售台次',
  `other_guestprice` float(6,2) DEFAULT NULL COMMENT '类型为其他客单价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='售后重点经营指标';

-- ----------------------------
--  Table structure for `think_kpi_runtargettype`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_runtargettype`;
CREATE TABLE `think_kpi_runtargettype` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点经营指标类型表ID',
  `type_name` varchar(30) DEFAULT NULL COMMENT '类型名称',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='[基础数据] 售后重点经营指标（类型名称表）[基础数据] ';

-- ----------------------------
--  Table structure for `think_kpi_store_carbrand`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_store_carbrand`;
CREATE TABLE `think_kpi_store_carbrand` (
  `store_id` int(3) NOT NULL COMMENT '门店id',
  `carbrand_id` int(3) NOT NULL COMMENT '品牌id',
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COMMENT='[基础数据]门店-品牌关系表';

-- ----------------------------
--  Table structure for `think_kpi_target_manage`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_target_manage`;
CREATE TABLE `think_kpi_target_manage` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点管理指标',
  `onetime_repair_rate_thatmonth` float(6,2) DEFAULT NULL COMMENT '一次性修复率(当月)',
  `onetime_repair_rate_monthchain` float(6,2) DEFAULT NULL COMMENT '一次性修复率(月环比)',
  `onetime_repair_rate_monthyoy` float(6,2) DEFAULT NULL COMMENT '一次性修复率(月同比)',
  `ontime_turncar_rate_thatmonth` float(6,2) DEFAULT NULL COMMENT '准时交车率(当月)',
  `ontime_turncar_rate_monthchain` float(6,2) DEFAULT NULL COMMENT '准时交车率(月环比)',
  `ontime_turncae_rate_monthyoy` float(6,2) DEFAULT NULL COMMENT '准时交车率(月同比)',
  `parts_turnore_rete_thatmonth` float(6,2) DEFAULT NULL COMMENT '备件周转率（月环比）',
  `parts_turnore_rate_monthchain` float(6,2) DEFAULT NULL COMMENT '备件周转率（月环比）',
  `parts_turnore_rate_monthyoy` float(6,2) DEFAULT NULL COMMENT '备件周转率（月环比）',
  `onetime_supply_rate_thatmonth` float(6,2) DEFAULT NULL COMMENT '一次供货率（当月）',
  `onetime_supply_rate_monthchain` float(6,2) DEFAULT NULL COMMENT '一次供货率（月环比）',
  `onetime_supply_rate_monthyoy` float(6,2) DEFAULT NULL COMMENT '一次供货率（月同比）',
  `station_turnore_rate_electrical_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率(机电)台次（当月）',
  `station_turnore_rate_electrical_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率（机电）台次（月环比）',
  `station_turnore_rate_electrical_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率（机电）台次（月同比）',
  `station_turnore_rate_coinspray_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率钣喷（台次）（当月）',
  `station_turnore_rate_coinspray_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率钣喷（台次）（月环比）',
  `station_turnore_rate_coinspray_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '工位周转率钣喷（台次）（月同比）',
  `aftificial_rate_receptionele_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台机电（台次）（当月）',
  `aftificial_rate_receptionele_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台机电（月环比）',
  `aftificial_rate_receptionele_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台机电（月同比）',
  `aftificial_rate_reception_accident_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台事故（当月）',
  `aftificial_rate_reception_accident_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台事故（月环比）',
  `aftificial_rate_reception_accident_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率前台事故（月同比）',
  `aftificial_rate_electrical_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率机电(当月)',
  `aftificial_rate_electrical_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率机电（月环比）',
  `aftificial_rate_electrical_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率机电（月同比）',
  `aftificial_rate_coinspray_thatmonth` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率钣喷（当月）',
  `aftificial_rate_coinspray_monthchain` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率钣喷（月环比）',
  `aftificial_rate_coinspray_monthyoy` decimal(12,2) DEFAULT 0.00 COMMENT '人工效率钣喷（月同比）',
  `year` decimal(12,2) DEFAULT 0.00 COMMENT '年',
  `month` decimal(12,2) DEFAULT 0.00 COMMENT '录入时间',
  `store_id` decimal(3,0) DEFAULT 0 COMMENT '门店id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='售后重点管理指标';

-- ----------------------------
--  Table structure for `think_kpi_targetmvas`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_targetmvas`;
CREATE TABLE `think_kpi_targetmvas` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '售后重点增值业务指标表ID',
  `thatmonth_complete` decimal(12,2) DEFAULT NULL COMMENT '当月完成（万元）',
  `month_yoy` decimal(12,2) DEFAULT NULL COMMENT '月同比',
  `month_chain` decimal(12,2) DEFAULT NULL COMMENT '月环比',
  `thatyear_total` decimal(12,2) DEFAULT NULL COMMENT '当年累计',
  `MVASname_id` int(3) DEFAULT NULL COMMENT '增值业务指标名称id（对应think_kpi_MVSAname表id）',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `add_time` int(11) DEFAULT NULL COMMENT '录入时间',
  `store_id` int(3) DEFAULT NULL COMMENT '门店ID',
  `total_yoy` decimal(12,2) DEFAULT NULL COMMENT '累计同比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='售后重点增值业务指标表';

-- ----------------------------
--  Table structure for `think_kpi_task`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_task`;
CREATE TABLE `think_kpi_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carseries_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `month` int(2) NOT NULL,
  `task` int(7) NOT NULL COMMENT '本月任务',
  `actual` int(7) NOT NULL COMMENT '实际完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=617 DEFAULT CHARSET=utf8 COMMENT='厂家任务';

-- ----------------------------
--  Table structure for `think_kpi_task_quarter`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_task_quarter`;
CREATE TABLE `think_kpi_task_quarter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carseries_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `quter` int(1) NOT NULL COMMENT '1.第一季度，2.第二季度，3.第三季度，4.第四季度',
  `task` int(7) NOT NULL COMMENT '季度考核任务',
  `actual` int(7) NOT NULL COMMENT '季度累计完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='厂家任务（季度）[*已废除*]';

-- ----------------------------
--  Table structure for `think_kpi_taxmeasure`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_taxmeasure`;
CREATE TABLE `think_kpi_taxmeasure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年份',
  `month` int(2) NOT NULL COMMENT '月份',
  `keep_the_balance` float(11,2) NOT NULL COMMENT '月初增值税留底余额',
  `sales_vat` float(11,2) NOT NULL COMMENT '当期销售增值税',
  `current_deductible` float(11,2) NOT NULL COMMENT '当期可抵扣增值税项',
  `other_taxes` float(11,2) NOT NULL COMMENT '其他税项',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='税金测算表表';

-- ----------------------------
--  Table structure for `think_kpi_threerollcar`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_threerollcar`;
CREATE TABLE `think_kpi_threerollcar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '公司id',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月份',
  `type` int(2) DEFAULT NULL COMMENT '类型：1销量，2进车数量，3期末库存',
  `carseries_id` int(11) DEFAULT NULL COMMENT '车系id',
  `expect` varchar(50) DEFAULT NULL COMMENT '预计',
  `actual` varchar(50) DEFAULT NULL COMMENT '实际',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6393 DEFAULT CHARSET=utf8 COMMENT='三月滚动库存（整车）';

-- ----------------------------
--  Table structure for `think_kpi_threerollcar_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_threerollcar_copy`;
CREATE TABLE `think_kpi_threerollcar_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '公司id',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月份',
  `type` int(2) DEFAULT NULL COMMENT '类型：1销量，2进车数量，3期末库存',
  `carseries_id` int(11) DEFAULT NULL COMMENT '车系id',
  `expect` varchar(50) DEFAULT NULL COMMENT '预计',
  `actual` varchar(50) DEFAULT NULL COMMENT '实际',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6025 DEFAULT CHARSET=utf8 COMMENT='三月滚动库存（整车）';

-- ----------------------------
--  Table structure for `think_kpi_threerollcar_over`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_threerollcar_over`;
CREATE TABLE `think_kpi_threerollcar_over` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '门店id',
  `year` int(2) DEFAULT NULL COMMENT '年',
  `month` int(2) DEFAULT NULL COMMENT '月',
  `three_month_expect` int(8) DEFAULT NULL COMMENT '90天以上超期库存量下月预计',
  `three_month_actual` int(8) DEFAULT NULL COMMENT '90天以上超期库存量本月实际',
  `six_month_expect` int(8) DEFAULT NULL COMMENT '180天以上超期库存量预计',
  `six_month_actual` int(8) DEFAULT NULL COMMENT '180天以上超期库存量实际',
  `one_year_expect` int(8) DEFAULT NULL COMMENT '一年以上超期库存量下月预计',
  `one_year_actual` int(8) DEFAULT NULL COMMENT '一年以上超期库存量本月实际',
  `two_year_expect` int(8) DEFAULT NULL COMMENT '两年以上超期库存量预计',
  `two_year_actual` int(8) DEFAULT NULL COMMENT '两年以上超期库存量实际',
  `cash_expect` decimal(8,2) DEFAULT NULL COMMENT '现款（万元）下月预计',
  `cash_actual` decimal(8,2) DEFAULT NULL COMMENT '现款（万元）本月实际',
  `bank_bill_expect` decimal(8,2) DEFAULT NULL COMMENT '银行票据（万元）下月预计',
  `bank_bill_actual` decimal(8,2) DEFAULT NULL COMMENT '银行票据（万元）本月实际',
  `financing_expect` decimal(8,2) DEFAULT NULL COMMENT '厂家融资（万元）下月预计',
  `financing_actual` decimal(8,2) DEFAULT NULL COMMENT '厂家融资（万元）本月实际',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8 COMMENT='三月滚动库存（整车）超期数（下半部分数据表）';

-- ----------------------------
--  Table structure for `think_kpi_threerollparts`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_threerollparts`;
CREATE TABLE `think_kpi_threerollparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `type` int(1) NOT NULL COMMENT '分类：0.配件销售,1.配件购进,2.期末库存,3.配件分类当量,4.一年以上的库存',
  `boutique_expect` decimal(9,2) DEFAULT NULL COMMENT '装饰美容精品件本月预计',
  `boutique_actual` decimal(9,2) DEFAULT NULL COMMENT '装饰美容精品件实际',
  `maintain_expect` decimal(9,2) DEFAULT NULL COMMENT '保养预计',
  `maintain_actual` decimal(9,2) DEFAULT NULL COMMENT '保养实际',
  `metal_actual` decimal(9,2) DEFAULT NULL COMMENT '钣喷本月实际',
  `metal_expect` decimal(9,2) DEFAULT NULL COMMENT '钣喷本月预计',
  `repair_expect` decimal(9,2) DEFAULT NULL COMMENT '一般维修预计',
  `repair_actual` decimal(9,2) DEFAULT NULL COMMENT '一般维修实际',
  `oil_expect` decimal(9,2) DEFAULT NULL COMMENT '机油本月预计',
  `oil_actual` decimal(9,2) DEFAULT NULL COMMENT '机油b本月实际',
  `chemical_expect` decimal(9,2) DEFAULT NULL COMMENT '化学品本月预计',
  `chemical_actual` decimal(9,2) DEFAULT NULL COMMENT '化学品本月实际',
  `battery_expect` decimal(9,2) DEFAULT NULL COMMENT '电瓶本月预计',
  `battery_actual` decimal(9,2) DEFAULT NULL COMMENT '电瓶本月实际',
  `tyre_expect` decimal(9,2) DEFAULT NULL COMMENT '轮胎本月预计',
  `tyre_actual` decimal(9,2) DEFAULT NULL COMMENT '轮胎本月实际',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=326 DEFAULT CHARSET=utf8 COMMENT='三月滚动库存（配件）';

-- ----------------------------
--  Table structure for `think_kpi_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_kpi_user_role`;
CREATE TABLE `think_kpi_user_role` (
  `emp_no` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_del` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='[基础数据] 用户表';

-- ----------------------------
--  Table structure for `think_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_log`;
CREATE TABLE `think_log` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `content1` varchar(100) DEFAULT NULL,
  `content2` varchar(100) DEFAULT NULL,
  `content3` varchar(100) DEFAULT NULL,
  `content4` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31233 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_mail`
-- ----------------------------
DROP TABLE IF EXISTS `think_mail`;
CREATE TABLE `think_mail` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `folder` int(11) NOT NULL DEFAULT 0 COMMENT '文件夹',
  `mid` varchar(200) DEFAULT NULL COMMENT '邮件唯一id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text NOT NULL COMMENT '内容',
  `add_file` varchar(200) DEFAULT NULL COMMENT '附件',
  `from` varchar(255) DEFAULT NULL COMMENT '发件人',
  `to` varchar(255) DEFAULT NULL COMMENT '收件人',
  `reply_to` varchar(255) DEFAULT NULL COMMENT '回复到',
  `cc` varchar(255) DEFAULT NULL COMMENT '抄送',
  `read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '已读',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_mail_account`
-- ----------------------------
DROP TABLE IF EXISTS `think_mail_account`;
CREATE TABLE `think_mail_account` (
  `id` mediumint(6) NOT NULL,
  `email` varchar(50) DEFAULT NULL COMMENT '邮件地址',
  `mail_name` varchar(50) NOT NULL DEFAULT '' COMMENT '邮件显示名称',
  `pop3svr` varchar(50) NOT NULL DEFAULT '' COMMENT 'pop服务器',
  `smtpsvr` varchar(50) NOT NULL DEFAULT '' COMMENT 'smtp服务器',
  `mail_id` varchar(50) NOT NULL DEFAULT '' COMMENT '邮件ID',
  `mail_pwd` varchar(50) NOT NULL DEFAULT '' COMMENT '邮件密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='think_user_info';

-- ----------------------------
--  Table structure for `think_mail_organize`
-- ----------------------------
DROP TABLE IF EXISTS `think_mail_organize`;
CREATE TABLE `think_mail_organize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `sender_check` int(11) NOT NULL DEFAULT 0 COMMENT '是否确认发件人',
  `sender_option` int(11) NOT NULL DEFAULT 0 COMMENT '发件人选项',
  `sender_key` varchar(50) NOT NULL DEFAULT '' COMMENT '确认发件人值',
  `domain_check` int(11) NOT NULL DEFAULT 0 COMMENT '是否确认域名',
  `domain_option` int(11) NOT NULL DEFAULT 0 COMMENT '域名选项',
  `domain_key` varchar(50) NOT NULL DEFAULT '' COMMENT '确认域名值',
  `recever_check` int(11) NOT NULL DEFAULT 0 COMMENT '是否确认收件人',
  `recever_option` int(11) NOT NULL DEFAULT 0 COMMENT '收件人选项',
  `recever_key` varchar(50) NOT NULL DEFAULT '' COMMENT '确认收信人值',
  `title_check` int(11) NOT NULL DEFAULT 0 COMMENT '是否确认标题',
  `title_option` int(11) NOT NULL DEFAULT 0 COMMENT '确认标题选项',
  `title_key` varchar(50) NOT NULL DEFAULT '' COMMENT '确认标题值',
  `to` int(11) NOT NULL DEFAULT 0 COMMENT '移动到',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_message`
-- ----------------------------
DROP TABLE IF EXISTS `think_message`;
CREATE TABLE `think_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text DEFAULT NULL COMMENT '内容',
  `add_file` varchar(200) DEFAULT NULL COMMENT '附件',
  `sender_id` int(11) DEFAULT NULL COMMENT '发送人',
  `sender_name` varchar(20) DEFAULT NULL COMMENT '发送人名称',
  `receiver_id` int(11) DEFAULT NULL COMMENT '接收人',
  `receiver_name` varchar(20) DEFAULT NULL COMMENT '接收人名称',
  `create_time` int(11) DEFAULT 0 COMMENT '创建时间',
  `owner_id` int(11) DEFAULT NULL COMMENT '拥有者',
  `is_del` tinyint(3) DEFAULT 0 COMMENT '删除标记',
  `is_read` tinyint(3) DEFAULT 0 COMMENT '是否已读',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_node`
-- ----------------------------
DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT 'URL地址',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `sub_folder` varchar(20) DEFAULT NULL COMMENT '子文件夹',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` varchar(20) DEFAULT NULL COMMENT '排序',
  `pid` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT '父ID',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `badge_function` varchar(50) DEFAULT NULL COMMENT '统计函数',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`is_del`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8 COMMENT='功能模块';

-- ----------------------------
--  Table structure for `think_pos_abnormal`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_abnormal`;
CREATE TABLE `think_pos_abnormal` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(30) NOT NULL COMMENT '账号',
  `year` int(4) DEFAULT NULL COMMENT '年',
  `month` int(3) DEFAULT NULL COMMENT '月',
  `day` int(11) NOT NULL COMMENT '日期',
  `dept_id` int(7) NOT NULL COMMENT '部门id',
  `dept_name` varchar(30) NOT NULL COMMENT '部门名称',
  `com_id` int(7) DEFAULT NULL,
  `user_name` varchar(30) NOT NULL COMMENT '姓名',
  `position` varchar(30) NOT NULL COMMENT '职位',
  `type` varchar(20) DEFAULT NULL COMMENT '日期类型',
  `schedual` varchar(30) DEFAULT NULL COMMENT '班次',
  `time` varchar(30) DEFAULT NULL COMMENT '考勤时间，例：xx:xx-xx:xx',
  `punch_time` varchar(30) DEFAULT NULL COMMENT '打卡时间',
  `status` varchar(30) DEFAULT NULL COMMENT '异常状态(未签到，未签退，迟到，早退)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=240350 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='异常考勤表';

-- ----------------------------
--  Table structure for `think_pos_com`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_com`;
CREATE TABLE `think_pos_com` (
  `emp_no` varchar(255) NOT NULL COMMENT '账号',
  `com_ids` varchar(255) NOT NULL COMMENT '公司id，例如：1，2，3，4'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='考勤数据权限表';

-- ----------------------------
--  Table structure for `think_pos_com_schedual`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_com_schedual`;
CREATE TABLE `think_pos_com_schedual` (
  `com_id` int(3) NOT NULL COMMENT '门店id',
  `schedual_id` varchar(100) DEFAULT NULL COMMENT '班次id',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班次管理(门店-班次对应表)';

-- ----------------------------
--  Table structure for `think_pos_fillworkday`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_fillworkday`;
CREATE TABLE `think_pos_fillworkday` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `day` varchar(10) NOT NULL COMMENT '节假日天数',
  `playday_id` int(5) NOT NULL COMMENT '休息日id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='补班日';

-- ----------------------------
--  Table structure for `think_pos_form`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_form`;
CREATE TABLE `think_pos_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '考勤日报id',
  `emp_no` varchar(40) NOT NULL COMMENT '账号',
  `user_name` varchar(20) NOT NULL COMMENT '姓名',
  `dept_name` varchar(50) NOT NULL COMMENT '部门',
  `com_id` int(4) NOT NULL COMMENT '公司名id',
  `position` varchar(40) NOT NULL COMMENT '职位',
  `type` varchar(30) NOT NULL COMMENT '日期类型',
  `year` int(4) DEFAULT NULL COMMENT '年份',
  `month` int(2) NOT NULL COMMENT '月份',
  `day` int(11) DEFAULT NULL COMMENT '日',
  `schedule` varchar(20) NOT NULL COMMENT '班次',
  `on_work_time` varchar(20) NOT NULL COMMENT '上班时间',
  `out_work_time` varchar(20) NOT NULL COMMENT '下班时间',
  `sign_in` varchar(11) NOT NULL COMMENT '签到打卡时间',
  `sign_out` varchar(11) NOT NULL COMMENT '签退打卡时间',
  `work_time` float(8,3) NOT NULL COMMENT '工作时长（小时）',
  `salary_time` float(8,3) NOT NULL COMMENT '计薪时长（小时）',
  `late_time` int(8) NOT NULL COMMENT '迟到时间（分钟）',
  `late_times` int(4) NOT NULL COMMENT '迟到次数',
  `leave_early_time` int(8) NOT NULL COMMENT '早退时间（分钟）',
  `leave_early_times` int(4) NOT NULL COMMENT '早退次数',
  `absent_time` float(8,3) NOT NULL COMMENT '旷工时长(小时）',
  `absent_times` int(2) NOT NULL COMMENT '旷工次数',
  `adjust_time` float(8,3) NOT NULL COMMENT '调休时间（小时）',
  `adjust_times` int(2) NOT NULL COMMENT '调休次数',
  `over_time` float(8,3) NOT NULL COMMENT '加班时间（小时）',
  `over_times` int(2) NOT NULL COMMENT '加班次数（次）',
  `out_time` float(8,3) NOT NULL COMMENT '外出时间（小时）',
  `out_times` int(2) NOT NULL COMMENT '外出次数',
  `leave_time` float(8,3) NOT NULL COMMENT '请假时间（小时）',
  `leave_times` int(2) NOT NULL COMMENT '请假次数',
  `leave_type` varchar(50) NOT NULL COMMENT '请假类型',
  `year_time` float(8,3) NOT NULL COMMENT '年假（小时）',
  `sick_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '病假（小时）',
  `marriage_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '婚假（小时）',
  `maternity_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '产假（小时）',
  `death_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '丧假（小时）',
  `thing_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '事假(小时）',
  `other_time` float(8,3) DEFAULT 0.000 COMMENT '其他假期（小时）',
  `business_time` float(8,3) NOT NULL DEFAULT 0.000 COMMENT '出差（小时）',
  `business_times` int(1) DEFAULT 0,
  `surplus_year_time` float(8,3) NOT NULL COMMENT '剩余年假（小时）',
  `surplus_adjust_time` float(8,3) NOT NULL COMMENT '剩余调休(小时）',
  `posid_start` int(11) NOT NULL COMMENT '签到id',
  `posid_end` int(11) NOT NULL COMMENT '签退id',
  `is_ok` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247915 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='考勤日报表';

-- ----------------------------
--  Table structure for `think_pos_form_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_form_copy`;
CREATE TABLE `think_pos_form_copy` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '考勤日报id',
  `emp_no` varchar(40) NOT NULL COMMENT '账号',
  `user_name` varchar(20) NOT NULL COMMENT '姓名',
  `dept_name` varchar(50) NOT NULL COMMENT '部门',
  `com_id` int(4) DEFAULT NULL COMMENT '公司名id',
  `position` varchar(40) NOT NULL COMMENT '职位',
  `type` varchar(30) NOT NULL COMMENT '日期类型',
  `year` int(4) DEFAULT NULL COMMENT '年份',
  `month` int(2) NOT NULL COMMENT '月份',
  `day` int(11) DEFAULT NULL COMMENT '日',
  `schedule` varchar(20) NOT NULL COMMENT '班次',
  `on_work_time` varchar(20) NOT NULL COMMENT '上班时间',
  `out_work_time` varchar(20) NOT NULL COMMENT '下班时间',
  `sign_in` varchar(11) NOT NULL COMMENT '签到打卡时间',
  `sign_out` varchar(11) NOT NULL COMMENT '签退打卡时间',
  `work_time` float(8,3) NOT NULL COMMENT '工作时长（小时）',
  `salary_time` float(8,3) NOT NULL COMMENT '计薪时长（小时）',
  `late_time` int(8) NOT NULL COMMENT '迟到时间（分钟）',
  `late_times` int(4) NOT NULL COMMENT '迟到次数',
  `leave_early_time` int(8) NOT NULL COMMENT '早退时间（分钟）',
  `leave_early_times` int(4) NOT NULL COMMENT '早退次数',
  `absent_time` float(8,3) NOT NULL COMMENT '旷工时长(小时）',
  `absent_times` int(2) NOT NULL COMMENT '旷工次数',
  `adjust_time` float(8,3) NOT NULL COMMENT '调休时间（小时）',
  `adjust_times` int(2) NOT NULL COMMENT '调休次数',
  `out_time` float(8,3) NOT NULL COMMENT '外出时间（小时）',
  `out_times` int(2) NOT NULL COMMENT '外出次数',
  `leave_time` float(8,3) NOT NULL COMMENT '请假时间（小时）',
  `leave_times` int(2) NOT NULL COMMENT '请假次数',
  `leave_type` varchar(50) NOT NULL COMMENT '请假类型',
  `marriage_time` float(8,3) NOT NULL COMMENT '婚假（小时）',
  `year_time` float(8,3) NOT NULL COMMENT '年假（小时）',
  `sick_time` float(8,3) NOT NULL COMMENT '病假（小时）',
  `maternity_time` float(8,3) NOT NULL COMMENT '产假（小时）',
  `death_time` float(8,3) NOT NULL COMMENT '丧假（小时）',
  `thing_time` float(8,3) NOT NULL COMMENT '事假(小时）',
  `over_time` float(8,3) NOT NULL COMMENT '加班时间（小时）',
  `over_times` int(2) NOT NULL COMMENT '加班次数（次）',
  `business_time` float(8,3) NOT NULL COMMENT '出差（小时）',
  `surplus_year_time` float(8,3) NOT NULL COMMENT '剩余年假（小时）',
  `surplus_adjust_time` float(8,3) NOT NULL COMMENT '剩余调休(小时）',
  `other_time` float(8,3) DEFAULT NULL COMMENT '其他假期（小时）',
  `posid_start` int(11) NOT NULL COMMENT '签到id',
  `posid_end` int(11) NOT NULL COMMENT '签退id',
  `is_ok` int(1) NOT NULL DEFAULT 0,
  `business_times` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7272 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `think_pos_holiday`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_holiday`;
CREATE TABLE `think_pos_holiday` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `day` varchar(10) NOT NULL COMMENT '节假日天数',
  `playday_id` int(5) NOT NULL COMMENT '休息日id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=295 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='假期';

-- ----------------------------
--  Table structure for `think_pos_playday`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_playday`;
CREATE TABLE `think_pos_playday` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `daily` varchar(30) DEFAULT NULL COMMENT '日常休息日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='休息日';

-- ----------------------------
--  Table structure for `think_pos_position_2017`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_position_2017`;
CREATE TABLE `think_pos_position_2017` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(20) NOT NULL COMMENT '用户账号',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '用户名称',
  `dept_id` int(11) NOT NULL COMMENT '部门id',
  `dept_name` varchar(30) NOT NULL COMMENT '部门名称',
  `com_id` int(11) NOT NULL COMMENT '公司id',
  `lat` decimal(10,7) NOT NULL COMMENT '纬度',
  `lng` decimal(10,7) NOT NULL COMMENT '经度',
  `position` varchar(20) NOT NULL COMMENT 'OA中职位',
  `address` varchar(100) DEFAULT NULL COMMENT '地址',
  `month` int(2) NOT NULL COMMENT '月份',
  `time` int(11) NOT NULL COMMENT '打卡时间戳',
  `year` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255149 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='考勤记录';

-- ----------------------------
--  Table structure for `think_pos_pri`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_pri`;
CREATE TABLE `think_pos_pri` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '功能名称',
  `pid` int(5) NOT NULL COMMENT '上级功能id',
  `url` varchar(40) DEFAULT NULL COMMENT '跳转地址，例如：模块名/控制器名/方法名',
  `is_admin` int(1) NOT NULL DEFAULT 0 COMMENT '是否需要管理员功能',
  `icon` varchar(20) NOT NULL COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='权限表';

-- ----------------------------
--  Table structure for `think_pos_rule`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_rule`;
CREATE TABLE `think_pos_rule` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '考勤规则名称',
  `range` varchar(100) NOT NULL COMMENT '运用范围',
  `way_ids` varchar(100) NOT NULL COMMENT '打卡方式id,例:1,2,3,4',
  `playday_id` int(5) NOT NULL COMMENT '休息日id',
  `schedual_ids` varchar(100) NOT NULL COMMENT '班次id,例:1,2,3,5',
  `priority` int(8) unsigned DEFAULT NULL COMMENT '优先级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='考勤规则';

-- ----------------------------
--  Table structure for `think_pos_schedual`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_schedual`;
CREATE TABLE `think_pos_schedual` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(50) NOT NULL COMMENT '名称',
  `short` varchar(30) DEFAULT NULL COMMENT '简称',
  `work_start_time` varchar(12) NOT NULL COMMENT '上班时间',
  `work_end_time` varchar(12) NOT NULL COMMENT '下班时间',
  `is_work_theday` int(1) unsigned DEFAULT 1 COMMENT '工作是否当天：1:当天，2：次日',
  `workhours` float(2,1) NOT NULL COMMENT '记薪时长',
  `is_rest` int(1) DEFAULT NULL COMMENT '是否有休息时间',
  `rest_start_time` varchar(12) DEFAULT NULL COMMENT '休息开始时间',
  `rest_end_time` varchar(12) DEFAULT NULL COMMENT '休息结束时间',
  `clockin_start_time` varchar(12) NOT NULL COMMENT '打卡开始时间',
  `clockin_end_time` varchar(12) NOT NULL COMMENT '打卡结束时间',
  `is_clock_theday` int(1) DEFAULT 1 COMMENT '是否当前天打卡1：当天，2：次日',
  `add_time` int(12) DEFAULT NULL COMMENT '添加时间',
  `work_start_hour` int(2) NOT NULL COMMENT '上班时',
  `work_start_minute` int(2) NOT NULL COMMENT '上班分',
  `work_end_hour` int(2) NOT NULL COMMENT '下班时',
  `work_end_minute` int(2) NOT NULL COMMENT '下班分',
  `rest_start_hour` varchar(2) NOT NULL COMMENT '开始休息时',
  `rest_start_minute` varchar(2) NOT NULL COMMENT '开始休息分',
  `rest_end_hour` varchar(2) NOT NULL COMMENT '结束休息时',
  `rest_end_minute` varchar(2) NOT NULL COMMENT '结束休息分',
  `clockin_start_hour` varchar(2) NOT NULL COMMENT '开始打卡时',
  `clockin_start_minute` varchar(2) NOT NULL COMMENT '开始打卡分',
  `clockin_end_hour` varchar(2) NOT NULL COMMENT '结束打卡时',
  `clockin_end_minute` varchar(2) NOT NULL COMMENT '结束打卡分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='班次';

-- ----------------------------
--  Table structure for `think_pos_scheduling`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_scheduling`;
CREATE TABLE `think_pos_scheduling` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(30) NOT NULL COMMENT '账号',
  `user_name` varchar(30) NOT NULL COMMENT '用户名',
  `dept_id` int(5) NOT NULL COMMENT '部门id',
  `dept_name` varchar(30) NOT NULL COMMENT '部门名称',
  `position` varchar(50) NOT NULL COMMENT '职位',
  `year` int(4) NOT NULL COMMENT '年',
  `month` int(2) NOT NULL COMMENT '月',
  `day` int(2) NOT NULL COMMENT '日',
  `schedual_id` int(5) DEFAULT NULL COMMENT '班次id',
  `schedual_name` varchar(50) DEFAULT NULL COMMENT '班次名称',
  `way_ids` varchar(100) NOT NULL COMMENT '打卡方式id,例：1，2，3',
  `is_artificial` int(1) NOT NULL DEFAULT 0 COMMENT '是否手动录入：0否1是',
  `playday_id` int(3) DEFAULT NULL COMMENT '休息日',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=870327 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='排班';

-- ----------------------------
--  Table structure for `think_pos_way`
-- ----------------------------
DROP TABLE IF EXISTS `think_pos_way`;
CREATE TABLE `think_pos_way` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `address` varchar(100) NOT NULL COMMENT '考勤地址',
  `range` int(7) NOT NULL COMMENT '考勤范围',
  `lat` varchar(10) NOT NULL COMMENT '纬度',
  `lng` varchar(10) NOT NULL COMMENT '经度',
  `ps` varchar(100) DEFAULT NULL COMMENT '备注',
  `is_del` int(1) DEFAULT 0 COMMENT '是否禁用0启用1禁用',
  `add_time` varchar(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='打卡方式';

-- ----------------------------
--  Table structure for `think_position`
-- ----------------------------
DROP TABLE IF EXISTS `think_position`;
CREATE TABLE `think_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_no` varchar(10) NOT NULL DEFAULT '' COMMENT '编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `sort` varchar(10) NOT NULL DEFAULT '' COMMENT '排序',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='OA审批职位';

-- ----------------------------
--  Table structure for `think_project`
-- ----------------------------
DROP TABLE IF EXISTS `think_project`;
CREATE TABLE `think_project` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dept_name` varchar(30) DEFAULT NULL,
  `company` varchar(30) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL COMMENT '职位',
  `content` varchar(200) NOT NULL COMMENT '计划事项',
  `start_time` int(11) NOT NULL COMMENT '计划开始时间',
  `end_time` int(11) NOT NULL COMMENT '计划结束时间',
  `actual_time` int(11) DEFAULT NULL COMMENT '实际完成时间',
  `is_finish` int(1) DEFAULT NULL COMMENT '是否完成 0否 1是',
  `remark` varchar(180) DEFAULT NULL COMMENT '原因',
  `add_time` int(11) NOT NULL COMMENT '添加日期',
  `update_time` int(11) DEFAULT NULL COMMENT '更新日期',
  `com_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=319 DEFAULT CHARSET=utf8 COMMENT='IT双周计划表';

-- ----------------------------
--  Table structure for `think_push`
-- ----------------------------
DROP TABLE IF EXISTS `think_push`;
CREATE TABLE `think_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `data` text NOT NULL,
  `status` int(11) DEFAULT 0,
  `time` int(11) DEFAULT 0,
  `info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_rank`
-- ----------------------------
DROP TABLE IF EXISTS `think_rank`;
CREATE TABLE `think_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_no` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `sort` varchar(10) NOT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `pid` smallint(6) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT 0,
  `update_time` int(11) unsigned DEFAULT 0,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `node_id` int(4) unsigned DEFAULT NULL COMMENT ' 权限id',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`sort`),
  KEY `status` (`is_del`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='权限组';

-- ----------------------------
--  Table structure for `think_role_duty`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_duty`;
CREATE TABLE `think_role_duty` (
  `role_id` smallint(6) unsigned NOT NULL,
  `duty_id` smallint(6) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分配(业务角色-权限组对应表)';

-- ----------------------------
--  Table structure for `think_role_node`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_node`;
CREATE TABLE `think_role_node` (
  `role_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `write` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限组管理';

-- ----------------------------
--  Table structure for `think_role_node_copy`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_node_copy`;
CREATE TABLE `think_role_node_copy` (
  `role_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `write` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_user`;
CREATE TABLE `think_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限分配(人员-权限对应)';

-- ----------------------------
--  Table structure for `think_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `think_schedule`;
CREATE TABLE `think_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `content` text DEFAULT NULL,
  `location` varchar(50) DEFAULT '',
  `priority` int(11) DEFAULT NULL,
  `actor` varchar(200) DEFAULT '',
  `user_id` int(11) DEFAULT 0,
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `add_file` varchar(200) DEFAULT '',
  `is_del` tinyint(3) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_sign`
-- ----------------------------
DROP TABLE IF EXISTS `think_sign`;
CREATE TABLE `think_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sign_date` date DEFAULT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `is_real_time` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` date NOT NULL,
  `location` varchar(20) NOT NULL,
  `content` varchar(50) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_songji`
-- ----------------------------
DROP TABLE IF EXISTS `think_songji`;
CREATE TABLE `think_songji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(10) DEFAULT NULL,
  `flight_no` varchar(10) DEFAULT NULL,
  `depart_time` datetime DEFAULT NULL,
  `depart_location` varchar(200) DEFAULT NULL,
  `passenger_qty` tinyint(3) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `passenger` varchar(10) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `task_no` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `executor` varchar(200) DEFAULT NULL,
  `is_del` tinyint(3) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_songji_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_songji_log`;
CREATE TABLE `think_songji_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `assigner` int(11) DEFAULT NULL COMMENT '分配任务的人',
  `executor` varchar(20) DEFAULT NULL COMMENT '执行人',
  `executor_name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0,
  `plan_time` datetime DEFAULT NULL,
  `transactor_name` varchar(20) DEFAULT NULL,
  `transactor` int(11) DEFAULT NULL COMMENT '由谁处理的',
  `finish_rate` tinyint(3) DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `feed_back` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `think_supplier`;
CREATE TABLE `think_supplier` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `letter` varchar(50) DEFAULT '',
  `short` varchar(30) DEFAULT '',
  `account` varchar(20) DEFAULT '',
  `tax_no` varchar(20) DEFAULT '',
  `payment` varchar(20) DEFAULT NULL,
  `contact` varchar(20) NOT NULL DEFAULT '',
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) DEFAULT '',
  `email` varchar(50) DEFAULT '',
  `im` varchar(20) DEFAULT '',
  `address` varchar(50) DEFAULT '',
  `user_id` int(11) NOT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `remark` text DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `user_name` varchar(21) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_system_config`
-- ----------------------------
DROP TABLE IF EXISTS `think_system_config`;
CREATE TABLE `think_system_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `val` varchar(255) DEFAULT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `sort` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT 0,
  `data_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_system_folder`
-- ----------------------------
DROP TABLE IF EXISTS `think_system_folder`;
CREATE TABLE `think_system_folder` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `controller` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL,
  `admin` varchar(200) NOT NULL,
  `write` varchar(200) NOT NULL,
  `read` varchar(200) NOT NULL,
  `sort` varchar(20) NOT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COMMENT='信息发文分类';

-- ----------------------------
--  Table structure for `think_system_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_system_log`;
CREATE TABLE `think_system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `data` float DEFAULT NULL,
  `text` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_system_tag`
-- ----------------------------
DROP TABLE IF EXISTS `think_system_tag`;
CREATE TABLE `think_system_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `controller` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COMMENT='流程分组';

-- ----------------------------
--  Table structure for `think_system_tag_data`
-- ----------------------------
DROP TABLE IF EXISTS `think_system_tag_data`;
CREATE TABLE `think_system_tag_data` (
  `row_id` int(11) NOT NULL DEFAULT 0,
  `tag_id` int(11) NOT NULL DEFAULT 0,
  `controller` varchar(20) NOT NULL DEFAULT '',
  KEY `row_id` (`row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_carbrand`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_carbrand`;
CREATE TABLE `think_target_carbrand` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '车品牌表id',
  `carbrand_name` varchar(20) DEFAULT NULL COMMENT '车品牌名称',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销（0：否，1：是）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='金融指标-车品牌表';

-- ----------------------------
--  Table structure for `think_target_carseries`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_carseries`;
CREATE TABLE `think_target_carseries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车系id',
  `carseries_name` varchar(30) DEFAULT NULL COMMENT '车系名称',
  `is_import` int(1) unsigned DEFAULT NULL COMMENT '是否是进口（1：国产，2：进口）',
  `carbrand_id` int(11) unsigned DEFAULT NULL COMMENT '品牌id',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=305 DEFAULT CHARSET=utf8 COMMENT='金融指标-车系表';

-- ----------------------------
--  Table structure for `think_target_carsize`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_carsize`;
CREATE TABLE `think_target_carsize` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-车型表id',
  `carsize_name` varchar(30) DEFAULT NULL COMMENT '车型名称',
  `carseries_id` int(8) unsigned DEFAULT NULL COMMENT '车系id',
  `add_time` varchar(12) DEFAULT NULL COMMENT '创建时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=785 DEFAULT CHARSET=utf8 COMMENT='金融指标-车型表';

-- ----------------------------
--  Table structure for `think_target_channel`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_channel`;
CREATE TABLE `think_target_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-渠道表id',
  `channel_name` varchar(30) DEFAULT NULL COMMENT '渠道标题',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销（0：否，1：是）',
  `add_time` varchar(12) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='金融指标-渠道表';

-- ----------------------------
--  Table structure for `think_target_channeldata`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_channeldata`;
CREATE TABLE `think_target_channeldata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '销售数据采集表ID',
  `dept_id` int(3) unsigned DEFAULT NULL COMMENT '门店ID',
  `showroom` int(6) DEFAULT NULL COMMENT '展厅（台数）',
  `self_store` int(6) unsigned DEFAULT NULL COMMENT '自店二网',
  `tel_group` int(6) unsigned DEFAULT NULL COMMENT '电话组（台数）',
  `big_consumer` int(6) unsigned DEFAULT NULL COMMENT '大客户（台数）',
  `outer_permit` int(6) unsigned DEFAULT NULL COMMENT '外批（台数）',
  `inputtime` int(11) unsigned DEFAULT NULL COMMENT '录入时间',
  `add_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COMMENT='金融指标-销售车系数据采集表';

-- ----------------------------
--  Table structure for `think_target_chart1`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart1`;
CREATE TABLE `think_target_chart1` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL COMMENT '年份',
  `month` varchar(1) NOT NULL COMMENT '月份',
  `dm_id` int(11) NOT NULL COMMENT '店面id',
  `fdzt` int(5) DEFAULT NULL COMMENT '本月放款数量-展厅',
  `fdzd` int(5) DEFAULT NULL COMMENT '本月放款数量-自店二网',
  `fddh` int(5) DEFAULT NULL COMMENT '本月放款数量-电话',
  `fddk` int(5) DEFAULT NULL COMMENT '本月放款数量-大客',
  `fdwp` int(5) DEFAULT NULL COMMENT '本月放款数量-外批',
  `aspzt` float(10,2) DEFAULT NULL COMMENT '本月asp-展厅',
  `aspzd` float(10,2) DEFAULT NULL COMMENT '本月asp-自店二网',
  `aspdh` float(10,2) DEFAULT NULL COMMENT '本月asp-电话',
  `aspdk` float(10,2) DEFAULT NULL COMMENT '本月asp-大客',
  `aspwp` float(10,2) DEFAULT NULL COMMENT '本月asp-外批',
  `zxzt` float(10,2) DEFAULT NULL COMMENT '咨询-展厅',
  `zxzd` float(10,2) DEFAULT NULL COMMENT '咨询-自店二网',
  `zxdh` float(10,2) DEFAULT NULL COMMENT '咨询-电话',
  `zxdk` float(10,2) DEFAULT NULL COMMENT '咨询-大客',
  `zxwp` float(10,2) DEFAULT NULL COMMENT '咨询-外批',
  `stzt` float(10,4) DEFAULT NULL COMMENT '渗透率-展厅',
  `stzd` float(10,4) DEFAULT NULL COMMENT '渗透率-自店二网',
  `stdh` float(10,4) DEFAULT NULL COMMENT '渗透率-电话',
  `stdk` float(10,4) DEFAULT NULL COMMENT '渗透率-大客',
  `stwp` float(10,4) DEFAULT NULL COMMENT '渗透率-外批',
  `dyzt` float(10,2) DEFAULT NULL COMMENT '抵押-展厅',
  `dyzd` float(10,2) DEFAULT NULL COMMENT '抵押-自店二网',
  `dydh` float(10,2) DEFAULT NULL COMMENT '抵押-电话',
  `dydk` float(10,2) DEFAULT NULL COMMENT '抵押-大客',
  `dywp` float(10,2) DEFAULT NULL COMMENT '抵押-外批',
  `xlzt` int(5) DEFAULT NULL COMMENT '本月落户抵押费-展厅',
  `xlzd` int(5) DEFAULT NULL COMMENT '本月落户抵押费-自店二网',
  `xldh` int(5) DEFAULT NULL COMMENT '本月落户抵押费-电话',
  `xldk` int(5) DEFAULT NULL COMMENT '本月落户抵押费-大客',
  `xlwp` int(5) DEFAULT NULL COMMENT '本月落户抵押费-外批',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1437 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_chart2`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart2`;
CREATE TABLE `think_target_chart2` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `month` varchar(1) NOT NULL,
  `dm_id` int(11) DEFAULT NULL COMMENT '店面id',
  `carbrand_id` int(11) DEFAULT NULL,
  `carbrand` varchar(30) DEFAULT NULL,
  `carseries_id` int(11) DEFAULT NULL,
  `carseries` varchar(30) DEFAULT NULL,
  `fktc` int(5) DEFAULT NULL COMMENT '放款台次',
  `sf` float(10,2) DEFAULT NULL COMMENT '本月收费',
  `asp` float(10,2) DEFAULT NULL COMMENT '本月asp',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7161 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_chart3`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart3`;
CREATE TABLE `think_target_chart3` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `month` varchar(1) NOT NULL,
  `dm_id` int(11) NOT NULL,
  `carbrand_id` int(11) NOT NULL,
  `carbrand` varchar(30) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carseries` varchar(30) NOT NULL,
  `byst` float(10,4) NOT NULL COMMENT '本月渗透率',
  `syst` float(10,4) NOT NULL COMMENT '上月渗透率',
  `hb` float(10,4) NOT NULL COMMENT '环比',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6766 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_chart4`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart4`;
CREATE TABLE `think_target_chart4` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `month` varchar(1) NOT NULL,
  `dm_id` int(11) NOT NULL,
  `carbrand_id` int(11) NOT NULL,
  `carbrand` varchar(30) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carseries` varchar(30) NOT NULL,
  `byasp` float(10,4) NOT NULL COMMENT '本月asp',
  `syasp` float(10,4) NOT NULL COMMENT '上月asp',
  `hb` float(10,4) NOT NULL COMMENT '环比',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7128 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_chart5`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart5`;
CREATE TABLE `think_target_chart5` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `month` varchar(1) NOT NULL,
  `dm_id` int(11) NOT NULL,
  `dm` varchar(30) NOT NULL,
  `carbrand_id` int(11) NOT NULL,
  `carbrand` varchar(30) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carseries` varchar(30) NOT NULL,
  `bytc` int(10) NOT NULL COMMENT '本月台次',
  `sytc` int(10) NOT NULL COMMENT '上月台次',
  `hb` float(10,4) NOT NULL COMMENT '环比',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7128 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_chart6`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_chart6`;
CREATE TABLE `think_target_chart6` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL,
  `month` varchar(1) NOT NULL,
  `dm_id` int(11) NOT NULL,
  `dm` varchar(30) NOT NULL,
  `carbrand_id` int(11) NOT NULL,
  `carbrand` varchar(30) NOT NULL,
  `carseries_id` int(11) NOT NULL,
  `carseries` varchar(30) NOT NULL,
  `bysf` float(10,2) NOT NULL COMMENT '本月收费',
  `sysf` float(10,2) NOT NULL COMMENT '上月收费',
  `hb` float(10,4) NOT NULL COMMENT '环比',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7128 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_target_company`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_company`;
CREATE TABLE `think_target_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '金融-金融公司id',
  `company_name` varchar(30) DEFAULT NULL COMMENT '金融公司',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销（0：否，1：是）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='金融指标-金融公司表';

-- ----------------------------
--  Table structure for `think_target_library`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_library`;
CREATE TABLE `think_target_library` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '放款及咨询服务费类型表ID',
  `library_title` varchar(30) DEFAULT NULL COMMENT '放款及咨询服务费类型标题',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) unsigned DEFAULT 0 COMMENT '是否核销（0：否，1：是）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='金融指标-放款及咨询服务费类型表';

-- ----------------------------
--  Table structure for `think_target_loanbusiness`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_loanbusiness`;
CREATE TABLE `think_target_loanbusiness` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '车贷业务表id',
  `dept_id` int(3) unsigned DEFAULT NULL COMMENT '门店ID',
  `customer` varchar(30) DEFAULT NULL COMMENT '客户',
  `channel_id` int(2) unsigned DEFAULT NULL COMMENT '渠道id',
  `library_id` int(2) unsigned DEFAULT NULL COMMENT '放贷及咨询服务费类型id',
  `mortgage_status` int(1) unsigned DEFAULT NULL COMMENT '抵押状态',
  `zxservice_cost` float(10,2) DEFAULT NULL COMMENT '咨询服务费',
  `zxcost_time` int(11) DEFAULT NULL COMMENT '咨询服务费交款日期',
  `collateral` float(10,2) DEFAULT NULL COMMENT '保证金',
  `collateral_time` int(11) DEFAULT NULL COMMENT '续保证金时间',
  `settle_mortgage_cost` float(10,2) DEFAULT NULL COMMENT '落户抵押费',
  `settle_mortgage_time` int(11) DEFAULT NULL COMMENT '落户抵押缴费日期',
  `car_loan_time` int(11) DEFAULT NULL COMMENT '车贷申请日期',
  `sales_user` varchar(20) DEFAULT NULL COMMENT '销售顾问',
  `finance_service_manager` varchar(10) DEFAULT NULL COMMENT '金融服务经理',
  `finance_company_id` int(2) unsigned DEFAULT NULL COMMENT '金融公司id',
  `carbrand_id` int(3) unsigned DEFAULT NULL COMMENT '车品牌ID',
  `carseries_id` int(4) unsigned DEFAULT NULL COMMENT '车系id',
  `carsize_id` int(4) unsigned DEFAULT NULL COMMENT '车系id',
  `car_money` float(10,2) DEFAULT NULL COMMENT '车价格',
  `loan_money` float(10,2) DEFAULT NULL COMMENT '贷款金额',
  `deadline` int(4) DEFAULT NULL COMMENT '贷款期限',
  `permit_loan_money` float(10,2) DEFAULT NULL COMMENT '准贷金额',
  `loan_product_name` varchar(20) DEFAULT NULL COMMENT '贷款产品名称',
  `customer_telephone` varchar(11) DEFAULT NULL COMMENT '客服联系电话',
  `frame_number` varchar(22) DEFAULT NULL COMMENT '车架号',
  `remark` varchar(60) DEFAULT NULL COMMENT '备注',
  `entry_time` int(11) unsigned DEFAULT NULL COMMENT '录入时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `customer_telephone1` varchar(13) DEFAULT NULL COMMENT '客户电话座机',
  `customer_telephone2` varchar(13) DEFAULT NULL COMMENT '客户电话3',
  `is_del` int(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1805 DEFAULT CHARSET=utf8 COMMENT='金融指标-车贷业务表';

-- ----------------------------
--  Table structure for `think_target_seriesdata`
-- ----------------------------
DROP TABLE IF EXISTS `think_target_seriesdata`;
CREATE TABLE `think_target_seriesdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '销售车系数据表iD',
  `dept_id` int(3) unsigned DEFAULT NULL COMMENT '门店ID',
  `carbrand_id` int(3) unsigned DEFAULT NULL COMMENT '品牌id',
  `carserie_id` int(6) unsigned DEFAULT NULL COMMENT '车系id',
  `number` int(5) unsigned DEFAULT NULL COMMENT '台数',
  `inputtime` int(11) unsigned DEFAULT NULL COMMENT '录入时间',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `is_del` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=371 DEFAULT CHARSET=utf8 COMMENT='金融指标-销售车系数据表';

-- ----------------------------
--  Table structure for `think_task`
-- ----------------------------
DROP TABLE IF EXISTS `think_task`;
CREATE TABLE `think_task` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `task_no` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text DEFAULT NULL COMMENT '内容',
  `executor` varchar(200) DEFAULT NULL,
  `add_file` varchar(255) DEFAULT NULL,
  `expected_time` datetime DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT 0,
  `user_name` varchar(20) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_user_name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0,
  `is_del` tinyint(3) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_task_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_task_log`;
CREATE TABLE `think_task_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `assigner` int(11) DEFAULT NULL COMMENT '分配任务的人',
  `executor` varchar(20) DEFAULT NULL COMMENT '执行人',
  `executor_name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0,
  `plan_time` datetime DEFAULT NULL,
  `transactor_name` varchar(20) DEFAULT NULL,
  `transactor` int(11) DEFAULT NULL COMMENT '由谁处理的',
  `finish_rate` tinyint(3) DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `feed_back` text DEFAULT NULL,
  `add_file` text CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_todo`
-- ----------------------------
DROP TABLE IF EXISTS `think_todo`;
CREATE TABLE `think_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `end_date` varchar(10) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `add_file` varchar(200) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT 0,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_udf_field`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_field`;
CREATE TABLE `think_udf_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `row_type` int(11) NOT NULL,
  `sort` varchar(20) NOT NULL DEFAULT '0',
  `msg` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `validate` varchar(20) DEFAULT NULL,
  `controller` varchar(20) DEFAULT NULL,
  `is_del` tinyint(3) DEFAULT 0,
  `config` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=919 DEFAULT CHARSET=utf8 COMMENT='流程字段表';

-- ----------------------------
--  Table structure for `think_udf_field_copy0914`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_field_copy0914`;
CREATE TABLE `think_udf_field_copy0914` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `row_type` int(11) NOT NULL,
  `sort` varchar(20) NOT NULL DEFAULT '0',
  `msg` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `validate` varchar(20) DEFAULT NULL,
  `controller` varchar(20) DEFAULT NULL,
  `is_del` tinyint(3) DEFAULT 0,
  `config` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8 COMMENT='流程字段表';

-- ----------------------------
--  Table structure for `think_udf_renew`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_renew`;
CREATE TABLE `think_udf_renew` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `renew_date` date DEFAULT NULL,
  `shop_no` varchar(10) DEFAULT NULL,
  `shop_name` varchar(20) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_udf_sales`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_sales`;
CREATE TABLE `think_udf_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_date` date DEFAULT NULL,
  `shop_no` varchar(10) DEFAULT NULL,
  `shop_name` varchar(20) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_udf_shop`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_shop`;
CREATE TABLE `think_udf_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父级ID',
  `shop_no` varchar(20) NOT NULL DEFAULT '' COMMENT '部门编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `short` varchar(20) NOT NULL DEFAULT '' COMMENT '简称',
  `sort` varchar(20) NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `is_del` tinyint(3) NOT NULL DEFAULT 0 COMMENT '删除标记',
  `duty` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_udf_target`
-- ----------------------------
DROP TABLE IF EXISTS `think_udf_target`;
CREATE TABLE `think_udf_target` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(10) DEFAULT NULL,
  `shop_no` varchar(10) DEFAULT NULL,
  `shop_name` varchar(20) DEFAULT NULL,
  `renew_target` float DEFAULT NULL,
  `sales_target` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `nickname` varchar(20) NOT NULL DEFAULT '',
  `weixin` varchar(20) DEFAULT NULL,
  `password` char(32) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `com_id` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` int(8) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `duty` varchar(2000) DEFAULT NULL,
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `openid` varchar(50) DEFAULT NULL,
  `westatus` tinyint(3) DEFAULT 0,
  `init_pwd` tinyint(3) DEFAULT NULL,
  `pay_pwd` varchar(32) DEFAULT NULL,
  `is_scheduling` int(1) NOT NULL DEFAULT 0 COMMENT '是否可以排班 0否 1是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`emp_no`),
  KEY `mobile_tel` (`mobile_tel`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8268 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
--  Table structure for `think_user_backup0825`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_backup0825`;
CREATE TABLE `think_user_backup0825` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `nickname` varchar(20) NOT NULL DEFAULT '',
  `weixin` varchar(20) DEFAULT NULL,
  `password` char(32) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `com_id` int(11) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` int(8) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `duty` varchar(2000) DEFAULT NULL,
  `office_tel` varchar(20) DEFAULT NULL,
  `mobile_tel` varchar(20) NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `openid` varchar(50) DEFAULT NULL,
  `westatus` tinyint(3) DEFAULT 0,
  `init_pwd` tinyint(3) DEFAULT NULL,
  `pay_pwd` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`emp_no`),
  KEY `mobile_tel` (`mobile_tel`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7986 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_user_com`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_com`;
CREATE TABLE `think_user_com` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `em_no` varchar(20) DEFAULT NULL,
  `com_id` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11858 DEFAULT CHARSET=utf8 COMMENT='用户管理公司';

-- ----------------------------
--  Table structure for `think_user_config`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_config`;
CREATE TABLE `think_user_config` (
  `id` int(11) NOT NULL DEFAULT 0,
  `home_sort` varchar(255) DEFAULT NULL,
  `list_rows` int(11) DEFAULT 20,
  `readed_info` text DEFAULT NULL,
  `push_web` varchar(255) DEFAULT NULL,
  `push_wechat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_user_dept`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_dept`;
CREATE TABLE `think_user_dept` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `em_no` varchar(20) DEFAULT NULL COMMENT '微信账号',
  `dept_id` varchar(11) DEFAULT NULL COMMENT '部门id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24503 DEFAULT CHARSET=utf8 COMMENT='用户管理部门';

-- ----------------------------
--  Table structure for `think_user_folder`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_folder`;
CREATE TABLE `think_user_folder` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT 0,
  `controller` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_user_tag`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_tag`;
CREATE TABLE `think_user_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `controller` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `sort` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_user_tag_data`
-- ----------------------------
DROP TABLE IF EXISTS `think_user_tag_data`;
CREATE TABLE `think_user_tag_data` (
  `row_id` int(11) NOT NULL DEFAULT 0,
  `tag_id` int(11) NOT NULL DEFAULT 0,
  `controller` varchar(20) DEFAULT NULL,
  KEY `row_id` (`row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_work_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_work_log`;
CREATE TABLE `think_work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(20) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `plan` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_del` tinyint(3) NOT NULL DEFAULT 0,
  `add_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_work_order`
-- ----------------------------
DROP TABLE IF EXISTS `think_work_order`;
CREATE TABLE `think_work_order` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `task_no` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text DEFAULT NULL COMMENT '内容',
  `executor` varchar(200) DEFAULT NULL,
  `actor` varchar(200) DEFAULT '',
  `add_file` varchar(255) DEFAULT NULL,
  `request_arrive_time` datetime DEFAULT NULL,
  `request_finish_time` datetime DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT 0,
  `user_name` varchar(20) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `dept_name` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `update_user_name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0,
  `is_del` tinyint(3) DEFAULT 0,
  `other` varchar(20) DEFAULT NULL,
  `arrive_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL,
  `arrive_lat` varchar(10) DEFAULT NULL,
  `arrive_lng` varchar(10) DEFAULT NULL,
  `finish_lat` varchar(10) DEFAULT NULL,
  `finish_lng` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `think_work_order_log`
-- ----------------------------
DROP TABLE IF EXISTS `think_work_order_log`;
CREATE TABLE `think_work_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `assigner` int(11) DEFAULT NULL COMMENT '分配任务的人',
  `executor` varchar(20) DEFAULT NULL COMMENT '执行人',
  `executor_name` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT 0,
  `arrive_time` int(11) DEFAULT NULL,
  `transactor_name` varchar(20) DEFAULT NULL,
  `transactor` int(11) DEFAULT NULL COMMENT '由谁处理的',
  `finish_rate` tinyint(3) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL,
  `feed_back` text DEFAULT NULL,
  `arrive_lat` varchar(10) DEFAULT NULL,
  `arrive_lng` varchar(10) DEFAULT NULL,
  `finish_lat` varchar(10) DEFAULT NULL,
  `finish_lng` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `think_system_config` VALUES ('86', 'system_name', '', 'OA自动化办公系统', '0', null, '0', 'system'), ('87', 'system_license', '', '112dsa52a5rra53ar535fa32er13', '0', null, '0', 'system'), ('88', 'upload_file_ext', '', 'doc,docx,xls,xlsx,ppt,pptx,pdf,gif,png,tif,zip,rar,jpg,jpeg,txt', '0', null, '0', 'system'), ('89', 'login_verify_code', '', '', '0', null, '0', 'system'), ('97', 'ws_push_config', '', '101', '0', null, '0', 'push'), ('102', '记账-支出', '记账-支出', '记账-支出', '0', '1', '0', 'common'), ('103', 'FINANCE_PAYMENT_TYPE', '餐费', '餐费', '0', '1', '102', 'common'), ('104', 'FINANCE_PAYMENT_TYPE', '通讯费', '通讯费', '0', '2', '102', 'common'), ('105', 'FINANCE_PAYMENT_TYPE', '办公费', '办公费', '0', '3', '102', 'common'), ('106', '跟进类型', '跟进类型', '跟进类型', '0', '2', '0', 'common'), ('107', 'CRM_VISIT_TYPE', '咨询', '咨询', '0', '1', '106', 'common'), ('108', 'CRM_VISIT_TYPE', '介绍', '介绍', '0', '2', '106', 'common');
INSERT INTO `think_user` VALUES (
    '1', 'admin', '管理员', 'GLY', '', 'e10adc3949ba59abbe56e057f20f883e', '0', '0', '0', 'male', null, '0.0.0.0', '1816', 'Uploads/emp_pic/1.png', '', '系统管理员', '', '', '0', '0', '0', '', null, null, '', '0'
);
INSERT INTO `think_node` VALUES ('84', '管理', 'System/index', 'fa fa-cog', '', '', '999', '0', '0', ''), ('85', '邮件', 'Mail/index', 'fa fa-envelope', '', '', '13', '0', '1', 'badge_sum'), ('87', '审批', 'Flow/index', 'fa fa-pencil bc-flow', '', '', '2', '0', '0', 'badge_sum'), ('88', '信息', 'Info/index##', 'fa fa-pencil-square-o', 'InfoFolder', '', '4', '0', '0', 'badge_sum'), ('91', '日程', 'Schedule/index', 'fa fa-calendar bc-personal-schedule', '', '', '9', '198', '0', 'badge_count_schedule'), ('94', '职位', 'Position/index', null, null, '', '', '1', '0', null), ('100', '写信', 'Mail/add', null, '', '', '1', '85', '0', null), ('101', '收件箱', 'Mail/folder?fid=inbox', 'bc-mail-inbox', '', '', '3', '85', '0', 'badge_count_mail_inbox'), ('102', '邮件设置', '', null, null, null, '9', '85', '0', null), ('104', '垃圾箱', 'Mail/folder?fid=spambox', '', '', '', '5', '85', '0', null), ('105', '发件箱', 'Mail/folder?fid=outbox', '', '', '', '6', '85', '0', null), ('106', '已删除', 'Mail/folder?fid=delbox', '', '', '', '4', '85', '0', null), ('107', '草稿箱', 'Mail/folder?fid=darftbox', '', '', '', '7', '85', '0', null), ('108', '邮件帐户设置', 'MailAccount/index', null, '', '', '1', '102', '0', null), ('110', '公司信息管理', '', null, null, '', '1', '84', '0', null), ('112', '权限管理', '', null, null, '', '3', '84', '0', null), ('113', '系统设定', '', null, null, '', '4', '84', '0', null), ('114', '系统参数设置', 'SystemConfig/index', '', '', '', '2', '113', '0', ''), ('115', '组织图', 'Dept/index', '', '', '', '1', '110', '0', null), ('116', '员工登记', 'User/index', null, '', '', '5', '110', '0', null), ('118', '权限组管理', 'Role/index', '', '', '', '1', '112', '0', null), ('119', '权限设置', 'Role/node', '', '', '', '2', '112', '0', null), ('120', '权限分配', 'Role/user', '', '', '', '3', '112', '0', null), ('121', '菜单管理', 'Node/index', '', '', '', '1', '113', '0', null), ('123', '职位', 'Position/index', null, '', '', '2', '110', '0', null), ('124', '文件夹设置', 'Mail/folder_manage', '', '', '', '2', '102', '0', ''), ('125', '联系人', 'Contact/index', '', '', '', '1', '198', '0', null), ('126', '信息搜索', 'Info/index', '', '', '', '1', '88', '0', null), ('143', '邮件分类', 'MailOrganize/index', null, '', '', '', '102', '0', null), ('144', '发起', 'Flow/index', '', '', '', '1', '87', '0', null), ('146', '流程管理', 'FlowType/index', '', '', '', '9', '87', '0', ''), ('147', '待审批', 'Flow/folder?fid=confirm', 'bc-flow-confirm', '', '', '4', '87', '0', 'badge_count_flow_todo'), ('148', '已审批', 'Flow/folder?fid=finish', '', '', '', '5', '87', '0', ''), ('149', '草稿箱', 'Flow/folder?fid=darft', '', '', '', '2', '87', '0', ''), ('150', '已提交', 'Flow/folder?fid=submit', '', '', '', '3', '87', '0', ''), ('152', '待办', 'Todo/index', 'fa fa-tasks bc-personal-todo', '', '', '9', '198', '0', 'badge_count_todo'), ('153', '单位级别', 'DeptGrade/index', '', '', '', '4', '110', '0', null), ('156', '客户', 'Customer/index', null, '', '', '2', '157', '0', null), ('157', '通讯录', 'Staff/index', 'fa fa-group', '', '', '7', '0', '0', 'badge_sum'), ('158', '供应商', 'Supplier/index', null, '', '', '3', '157', '1', null), ('169', '职员', 'Staff/index', null, '', '', '', '157', '0', null), ('177', '我的文件夹', '##mail', 'bc-mail-myfolder', 'MailFolder', '', '8', '85', '0', 'badge_count_mail_user_folder'), ('184', '流程分组', 'FlowType/tag_manage', '', '', '', '8', '87', '0', null), ('185', '审批报告', 'Flow/folder?fid=report', 'bc-flow-receive', '', '', '9', '87', '0', ''), ('189', '信息管理', 'Info/folder_manage', '', '', '', 'C1', '88', '0', ''), ('190', '消息', 'Message/index', 'fa fa-inbox bc-message', '', '', '1', '198', '0', 'badge_count_message'), ('191', '用户设置', '', '', '', '', '99', '198', '0', ''), ('192', '用户资料', 'Profile/index', '', '', '', '', '191', '0', null), ('193', '修改密码', 'Profile/password', '', '', '', '', '191', '0', null), ('194', '用户设置', 'UserConfig/index', '', '', '', '999', '191', '0', null), ('198', '个人', 'Contact/index', 'fa fa-user bc-personal', '', '', '9', '0', '0', 'badge_sum'), ('205', '业务角色管理', 'Duty/index', '', '', '', '4', '112', '0', ''), ('206', '业务权限分配', 'Role/duty', '', '', '', '5', '112', '0', ''), ('214', '记账', 'Finance/index', 'fa fa-jpy', '', '', '3', '217', '0', ''), ('216', '日报', 'WorkLog/index', 'fa fa-book', '', '', '1', '217', '0', ''), ('217', '工作', 'WorkLog/index', 'fa fa-briefcase', '', '', '6', '0', '0', 'badge_sum'), ('219', '我的信息', 'Info/my_info', '', '', '', 'B1', '88', '0', null), ('220', '我的签收', 'Info/my_sign', '', '', '', 'B2', '88', '0', null), ('221', '文档', 'Doc/index##', 'fa fa-inbox', 'DocFolder', '', '41', '0', '1', 'badge_sum'), ('222', '文档管理', 'Doc/folder_manage', 'fa fa-inbox', '', '', '4', '221', '0', 'badge_sum'), ('226', '报表', 'Form/index##', 'fa fa-table', 'FormFolder', '', '5', '0', '1', 'badge_sum'), ('227', '报表管理', 'Form/folder_manage', 'fa fa-inbox', '', '', '4', '226', '0', 'badge_sum'), ('228', '报表字段类型', 'Form/field_type', 'fa fa-inbox', '', '', '5', '226', '0', 'badge_sum'), ('229', '群组', 'Group/index', 'fa fa-group', '', '', '7', '157', '0', 'badge_sum'), ('234', '参阅箱', 'Flow/folder?fid=receive', 'bc-flow-receive', '', '', '7', '87', '0', 'badge_count_flow_receive'), ('247', '设置', '', '', '', '', '3', '242', '0', ''), ('252', '任务', 'Task/index', '', '', '', '2', '217', '0', 'badge_count_task'), ('253', '首页', 'Index/index', 'fa fa-home home-icon', '', '', '1', '0', '0', 'badge_sum'), ('254', '考勤统计', 'Sign/index', 'fa fa-map-marker', null, ' ', '3', '0', '1', 'badge_sum'), ('255', '查看考勤', 'Sign/index', null, null, ' ', '1', '254', '0', null), ('256', '考勤统计', 'Sign/report', null, null, ' ', '2', '254', '0', null), ('257', '考勤', 'Sign/dinwei', null, null, ' ', '0', '254', '0', null), ('258', '抄送', 'Flow/folder?fid=refer', '', '', '', '6', '87', '0', ''), ('259', '金融指标', 'Loanbusiness/index', 'fa fa-bar-chart-o', '', null, '888', '0', '0', ''), ('260', '车贷业务', 'Loanbusiness/index', 'fa fa-cog', '', null, '', '259', '0', ''), ('261', '车贷业务基础数据', '', 'fa fa-cog', '', null, '', '259', '0', ''), ('262', '车品牌', 'Carbrand/index', 'fa fa-cog', '', null, '1', '261', '0', ''), ('264', '放款及咨询服务费类型', 'Library/index', 'fa fa-cog', '', null, '3', '261', '0', ''), ('265', '金融公司', 'Company/index', 'fa fa-cog', '', null, '4', '261', '0', ''), ('266', '车系', 'Carseries/index', 'fa fa-cog', '', null, '5', '261', '0', ''), ('267', '车型', 'Carsize/index', 'fa fa-cog', '', null, '6', '261', '0', ''), ('268', '渠道销售数据采集管理', 'Channeldata/index', 'fa fa-cog', '', null, '3', '259', '0', ''), ('269', '指标报表', '', 'fa fa-cog', '', null, '4', '259', '0', ''), ('270', '渠道指标表', 'Target/chart1', 'fa fa-cog', '', null, '1', '269', '0', ''), ('271', '车系渗透率指标表', 'Target/chart3', 'fa fa-cog', '', '', '3', '269', '0', ''), ('272', '车系金融基础三项指标表', 'Target/chart2', 'fa fa-cog', '', null, '2', '269', '0', ''), ('273', '车系ASP指标表', 'Target/chart4', 'fa fa-cog', '', null, '4', '269', '0', ''), ('274', '车系台次指标表', 'Target/chart5', 'fa fa-cog', '', null, '5', '269', '0', ''), ('275', '车系收费指标表', 'Target/chart6', 'fa fa-cog', '', null, '6', '269', '0', ''), ('276', '车系销售数据采集管理', 'Seriesdata/index', 'fa fa-cog', '', null, '4', '259', '0', ''), ('277', '同步', 'TargetChart/index', 'fa fa-cog', '', null, '89', '259', '0', ''), ('278', '单据意见', 'Flow/folder?fid=suggestion', '', '', null, '6', '87', '0', ''), ('279', '考勤', 'Public/kaoqin', 'fa fa-location-arrow', '', '', '7', '0', '0', ''), ('280', '计划', 'Project/index', '', '', null, '', '198', '0', ''), ('281', 'KPI', 'Public/kpi', 'fa fa-pie-chart', '', '', '7', '0', '0', '');
INSERT INTO `think_pos_pri` VALUES ('1', '考勤数据', '0', null, '0', ''), ('2', '考勤日报', '1', 'attendancedata/Daily/index', '0', ''), ('3', '考勤月报', '1', 'attendancedata/Month/index', '0', ''), ('4', '部门报表', '1', 'attendancedata/Dept/index', '0', ''), ('5', '异常考勤', '1', 'attendancedata/Abnormal/index', '0', ''), ('6', '打卡记录', '1', 'attendancedata/Recording/index', '0', ''), ('7', '考勤设置', '0', null, '0', ''), ('8', '考勤规则', '7', 'attendanceset/Rule/index', '1', ''), ('9', '打卡方式', '7', 'attendanceset/Clockway/index', '1', ''), ('10', '休息日', '7', 'attendanceset/Closed/index', '1', ''), ('11', '班次', '7', 'attendanceset/Shift/index', '1', ''), ('13', '排班视图', '7', 'attendanceset/Scheduling/index', '0', ''), ('14', '班次管理', '7', 'attendanceset/Manageshift/index', '0', ''), ('15', '新员工排班', '7', 'attendanceset/Schedulingset/index', '0', '');
INSERT INTO `think_role` VALUES ('1', '集团一级管理员', '0', '', '0', '1208784792', '1498114983', '0', null), ('2', '店面考勤管理员', '0', '', '0', '1215496283', '1501144602', '0', null), ('7', '店面员工', '0', '', '', '1254325787', '1501138381', '0', null), ('8', '系统管理员', '0', null, '0', '0', '0', '0', null), ('9', '集团员工', null, '', '', '1490083355', '1501138410', '0', null), ('10', '专用', null, '', '0', '1490933794', '1500369777', '0', null), ('11', '金融管理员', null, '', '5', '1493689309', '0', '0', '259'), ('12', '昆明宝远金融', null, '', '1', '1493880816', '1493882280', '0', null), ('13', '广州通立金融', null, '', '2', '1493883738', '0', '0', null), ('14', '中致远云达金融', null, '', '3', '1493883760', '0', '0', null), ('15', '上海大众金融', null, '', '4', '1493883780', '0', '0', null), ('16', '云南鸿通金融', null, '', '5', '1493883801', '0', '0', null), ('17', '云南凯迪金融', null, '', '6', '1493883834', '0', '0', null), ('18', '成都凯迪金融', null, '', '7', '1493883847', '0', '0', null), ('19', '英菲尼迪金融', null, '', '8', '1493883864', '0', '0', null), ('20', '昆明路威金融', null, '', '9', '1493883886', '0', '0', null), ('21', '红河通威金融', null, '', '10', '1493883900', '1493883960', '0', null), ('22', '红河威远金融', null, '', '11', '1493883982', '0', '0', null), ('23', '云南威远金融', null, '', '12', '1493883994', '0', '0', null), ('24', '玉溪宝远金融', null, '', '13', '1493884009', '0', '0', null), ('25', '玉溪鸿通金融', null, '', '14', '1493884030', '0', '0', null), ('26', '文山博用金融', null, '', '15', '1493884046', '0', '0', null), ('27', '曲靖鸿通金融', null, '', '16', '1493884059', '0', '0', null), ('28', '昆明博威金融', null, '', '17', '1493884076', '0', '0', null), ('29', '昆明宝远MINI金融', null, '', '18', '1493884123', '1493884154', '0', null), ('30', '大理宝远金融', null, '', '19', '1493884197', '0', '0', null), ('31', '绵阳路威金融', null, '', '20', '1493884218', '0', '0', null), ('32', '达州宝远金融', null, '', '21', '1493884235', '0', '0', null), ('33', '南宁宝远金融', null, '', '22', '1493884267', '0', '0', null), ('34', '宜宾宝远金融', null, '', '23', '1493884280', '0', '0', null), ('35', '昆明宝瀚金融', null, '', '24', '1493884299', '0', '0', null), ('36', '贵阳玛莎拉蒂金融', null, '', '25', '1493884312', '0', '0', null), ('37', '南宁玛莎拉蒂金融', null, '', '26', '1493884327', '0', '0', null), ('38', '上海凯迪金融', null, '', '27', '1493884339', '0', '0', null), ('39', '中致远合众金融', null, '', '28', '1493884357', '0', '0', null), ('40', '曲靖路威金融', null, '', '29', '1493884411', '0', '0', null), ('41', '昆明帝利金融', null, '', '30', '1493884453', '0', '0', null), ('42', '金融部总经理', null, '', '001', '1493947144', '0', '0', null), ('43', '金融部副总经理', null, '', '002', '1493947159', '0', '0', null), ('44', '金融督导', null, '', '003', '1493947182', '0', '0', null), ('45', '金融督导通用板块', null, '', '004', '1493947225', '0', '0', null), ('46', '信息管理部', null, '', '0', '1496200602', '1496200658', '0', null), ('47', '实业专用', null, '', '', '1500369789', '1502431858', '0', null), ('48', '店面部门经理', null, '', '', '1501138274', '0', '0', null), ('49', '店面总经理', null, '', '', '1501138292', '0', '0', null), ('50', '集团总经理', null, '', '', '1501138312', '0', '0', null), ('51', '高管', null, '', '', '1501138326', '1501138356', '0', null), ('52', '-店面IT', null, '', '', '1504184014', '1504184067', '0', null), ('53', '-店面行政经理', null, '', '', '1504184022', '1504184075', '0', null), ('54', '-店面保险索赔', null, '', '', '1504184030', '1504184081', '0', null), ('55', '--集团员工（副总裁只管）', null, '', '', '1504707347', '1505402270', '0', null), ('56', '个人计划', null, '', '0', '1504867254', '1504867281', '0', null), ('57', '--店面IT经理级', null, '', '', '1505402260', '0', '0', null), ('58', '备件经理', null, '', '', '1506063514', '1506063575', '0', null), ('59', 'KPI系统', null, '', '', '1506674325', '0', '0', null);
INSERT INTO `think_role_node` VALUES ('0', '0', '0', '0', '0'), ('2', '136', '0', '0', '0'), ('2', '135', '0', '0', '0'), ('1', '94', '0', '0', '0'), ('1', '97', '0', '0', '0'), ('1', '98', '0', '0', '0'), ('1', '99', '0', '0', '0'), ('1', '69', '0', '0', '0'), ('1', '6', '0', '0', '0'), ('1', '2', '0', '0', '0'), ('1', '7', '0', '0', '0'), ('1', '131', '1', '1', '1'), ('1', '130', '0', '0', '0'), ('1', '133', '0', '0', '0'), ('1', '132', '0', '0', '0'), ('1', '135', '0', '0', '0'), ('1', '136', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '134', '0', '0', '0'), ('2', '103', '0', '0', '0'), ('2', '133', '0', '0', '0'), ('2', '130', '0', '0', '0'), ('2', '134', '0', '0', '0'), ('2', '132', '0', '0', '0'), ('2', '103', '0', '0', '0'), ('2', '103', '0', '0', '0'), ('2', '109', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '103', '0', '0', '0'), ('1', '109', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '117', '0', '0', '0'), ('1', '163', '0', '0', '0'), ('1', '170', '0', '0', '0'), ('1', '164', '0', '0', '0'), ('1', '155', '0', '0', '0'), ('1', '154', '1', '1', '1'), ('1', '111', '0', '0', '0'), ('1', '168', '0', '0', '0'), ('1', '162', '0', '0', '0'), ('1', '166', '0', '0', '0'), ('1', '161', '0', '0', '0'), ('1', '171', '0', '0', '0'), ('1', '165', '0', '0', '0'), ('1', '174', '0', '0', '0'), ('1', '172', '0', '0', '0'), ('1', '173', '0', '0', '0'), ('1', '160', '0', '0', '0'), ('1', '175', '0', '0', '0'), ('1', '176', '0', '0', '0'), ('1', '167', '0', '0', '0'), ('1', '128', '0', '0', '0'), ('1', '242', '1', '1', '1'), ('1', '246', '1', '1', '1'), ('1', '247', '0', '0', '0'), ('1', '244', '0', '0', '0'), ('1', '245', '0', '0', '0'), ('1', '248', '1', '1', '1'), ('1', '249', '0', '0', '0'), ('1', '250', '0', '0', '0'), ('8', '94', '1', '1', '1'), ('8', '247', '1', '1', '1'), ('8', '263', '1', '1', '1'), ('11', '259', '1', '1', '1'), ('11', '261', '0', '0', '0'), ('11', '262', '1', '1', '1'), ('11', '263', '1', '1', '1'), ('11', '264', '1', '1', '1'), ('11', '265', '1', '1', '1'), ('11', '266', '1', '1', '1'), ('11', '267', '1', '1', '1'), ('11', '260', '1', '1', '1'), ('11', '268', '1', '1', '1'), ('11', '276', '1', '1', '1'), ('11', '269', '0', '0', '0'), ('11', '270', '0', '0', '0'), ('11', '272', '0', '0', '0'), ('11', '271', '0', '0', '0'), ('11', '273', '0', '0', '0'), ('11', '274', '0', '0', '0'), ('11', '275', '0', '0', '0'), ('11', '277', '1', '1', '1'), ('11', '84', '1', '1', '1'), ('11', '112', '0', '0', '0'), ('11', '118', '1', '1', '1'), ('11', '119', '0', '0', '0'), ('11', '120', '0', '0', '0'), ('12', '259', '1', '1', '1'), ('12', '260', '1', '1', '1'), ('12', '261', '0', '0', '0'), ('12', '262', '1', '1', '1'), ('12', '264', '1', '1', '1'), ('12', '265', '1', '1', '1'), ('12', '266', '1', '1', '1'), ('12', '267', '1', '1', '1'), ('12', '268', '1', '1', '1'), ('12', '276', '1', '1', '1'), ('12', '269', '0', '0', '0'), ('12', '270', '0', '0', '0'), ('12', '272', '0', '0', '0'), ('12', '271', '0', '0', '0'), ('12', '273', '0', '0', '0'), ('12', '274', '0', '0', '0'), ('12', '275', '0', '0', '0'), ('12', '277', '1', '1', '1'), ('21', '259', '1', '1', '1'), ('21', '260', '1', '1', '1'), ('21', '261', '0', '0', '0'), ('21', '262', '1', '1', '1'), ('21', '264', '1', '1', '1'), ('21', '265', '1', '1', '1'), ('21', '266', '1', '1', '1'), ('21', '267', '1', '1', '1'), ('21', '268', '1', '1', '1'), ('21', '276', '1', '1', '1'), ('21', '269', '0', '0', '0'), ('21', '270', '0', '0', '0'), ('21', '272', '0', '0', '0'), ('21', '271', '0', '0', '0'), ('21', '273', '0', '0', '0'), ('21', '274', '0', '0', '0'), ('21', '275', '0', '0', '0'), ('21', '277', '1', '1', '1'), ('22', '259', '1', '1', '1'), ('22', '260', '1', '1', '1'), ('22', '261', '0', '0', '0'), ('22', '262', '1', '1', '1'), ('22', '264', '1', '1', '1'), ('22', '265', '1', '1', '1'), ('22', '266', '1', '1', '1'), ('22', '267', '1', '1', '1'), ('22', '268', '1', '1', '1'), ('22', '276', '1', '1', '1'), ('22', '269', '0', '0', '0'), ('22', '270', '0', '0', '0'), ('22', '272', '0', '0', '0'), ('22', '271', '0', '0', '0'), ('22', '273', '0', '0', '0'), ('22', '274', '0', '0', '0'), ('22', '275', '0', '0', '0'), ('22', '277', '1', '1', '1'), ('23', '259', '1', '1', '1'), ('23', '260', '1', '1', '1'), ('23', '261', '0', '0', '0'), ('23', '262', '1', '1', '1'), ('23', '264', '1', '1', '1'), ('23', '265', '1', '1', '1'), ('23', '266', '1', '1', '1'), ('23', '267', '1', '1', '1'), ('23', '268', '1', '1', '1'), ('23', '276', '1', '1', '1'), ('23', '269', '0', '0', '0'), ('23', '270', '0', '0', '0'), ('23', '272', '0', '0', '0'), ('23', '271', '0', '0', '0'), ('23', '273', '0', '0', '0'), ('23', '274', '0', '0', '0'), ('23', '275', '0', '0', '0'), ('23', '277', '0', '0', '0'), ('24', '259', '1', '1', '1'), ('24', '260', '1', '1', '1'), ('24', '261', '0', '0', '0'), ('24', '262', '1', '1', '1'), ('24', '264', '1', '1', '1'), ('24', '265', '1', '1', '1'), ('24', '266', '1', '1', '1'), ('24', '267', '1', '1', '1'), ('24', '268', '1', '1', '1'), ('24', '276', '1', '1', '1'), ('24', '269', '0', '0', '0'), ('24', '270', '0', '0', '0'), ('24', '272', '0', '0', '0'), ('24', '271', '0', '0', '0'), ('24', '273', '0', '0', '0'), ('24', '274', '0', '0', '0'), ('24', '275', '0', '0', '0'), ('24', '277', '1', '1', '1'), ('25', '259', '1', '1', '1'), ('25', '260', '1', '1', '1'), ('25', '261', '0', '0', '0'), ('25', '262', '1', '1', '1'), ('25', '264', '1', '1', '1'), ('25', '265', '1', '1', '1'), ('25', '266', '1', '1', '1'), ('25', '267', '1', '1', '1'), ('25', '268', '1', '1', '1'), ('25', '276', '1', '1', '1'), ('25', '269', '0', '0', '0'), ('25', '270', '0', '0', '0'), ('25', '272', '0', '0', '0'), ('25', '271', '0', '0', '0'), ('25', '273', '0', '0', '0'), ('25', '274', '0', '0', '0'), ('25', '275', '0', '0', '0'), ('25', '277', '1', '1', '1'), ('26', '259', '1', '1', '1'), ('26', '260', '1', '1', '1'), ('26', '261', '0', '0', '0'), ('26', '262', '1', '1', '1'), ('26', '264', '1', '1', '1'), ('26', '265', '1', '1', '1'), ('26', '266', '1', '1', '1'), ('26', '267', '1', '1', '1'), ('26', '268', '1', '1', '1'), ('26', '276', '1', '1', '1'), ('26', '269', '0', '0', '0'), ('26', '270', '0', '0', '0'), ('26', '272', '0', '0', '0'), ('26', '271', '0', '0', '0'), ('26', '273', '0', '0', '0'), ('26', '274', '0', '0', '0'), ('26', '275', '0', '0', '0'), ('26', '277', '1', '1', '1'), ('27', '259', '1', '1', '1'), ('27', '260', '1', '1', '1'), ('27', '261', '0', '0', '0'), ('27', '262', '1', '1', '1'), ('27', '264', '1', '1', '1'), ('27', '265', '1', '1', '1'), ('27', '266', '1', '1', '1'), ('27', '267', '1', '1', '1'), ('27', '268', '1', '1', '1'), ('27', '276', '1', '1', '1'), ('27', '269', '0', '0', '0'), ('27', '270', '0', '0', '0'), ('27', '272', '0', '0', '0'), ('27', '271', '0', '0', '0'), ('27', '273', '0', '0', '0'), ('27', '274', '0', '0', '0'), ('27', '275', '0', '0', '0'), ('27', '277', '1', '1', '1'), ('28', '259', '1', '1', '1'), ('28', '260', '1', '1', '1'), ('28', '261', '0', '0', '0'), ('28', '262', '1', '1', '1'), ('28', '264', '1', '1', '1'), ('28', '265', '1', '1', '1'), ('28', '266', '1', '1', '1'), ('28', '267', '1', '1', '1'), ('28', '268', '1', '1', '1'), ('28', '276', '1', '1', '1'), ('28', '269', '0', '0', '0'), ('28', '270', '0', '0', '0'), ('28', '272', '0', '0', '0'), ('28', '271', '0', '0', '0'), ('28', '273', '0', '0', '0'), ('28', '274', '0', '0', '0'), ('28', '275', '0', '0', '0'), ('28', '277', '1', '1', '1'), ('29', '259', '1', '1', '1'), ('29', '260', '1', '1', '1'), ('29', '261', '0', '0', '0'), ('29', '262', '1', '1', '1'), ('29', '264', '1', '1', '1'), ('29', '265', '1', '1', '1'), ('29', '266', '1', '1', '1'), ('29', '267', '1', '1', '1'), ('29', '268', '1', '1', '1'), ('29', '276', '1', '1', '1'), ('29', '269', '0', '0', '0'), ('29', '270', '0', '0', '0'), ('29', '272', '0', '0', '0'), ('29', '271', '0', '0', '0'), ('29', '273', '0', '0', '0'), ('29', '274', '0', '0', '0'), ('29', '275', '0', '0', '0'), ('29', '277', '1', '1', '1'), ('30', '259', '1', '1', '1'), ('30', '260', '1', '1', '1'), ('30', '261', '0', '0', '0'), ('30', '262', '1', '1', '1'), ('30', '264', '1', '1', '1'), ('30', '265', '1', '1', '1'), ('30', '266', '1', '1', '1'), ('30', '267', '1', '1', '1'), ('30', '268', '1', '1', '1'), ('30', '276', '1', '1', '1'), ('30', '269', '0', '0', '0'), ('30', '270', '0', '0', '0'), ('30', '272', '0', '0', '0'), ('30', '271', '0', '0', '0'), ('30', '273', '0', '0', '0'), ('30', '274', '0', '0', '0'), ('30', '275', '0', '0', '0'), ('30', '277', '1', '1', '1'), ('13', '259', '1', '1', '1'), ('13', '260', '1', '1', '1'), ('13', '261', '0', '0', '0'), ('13', '262', '1', '1', '1'), ('13', '264', '1', '1', '1'), ('13', '265', '1', '1', '1'), ('13', '266', '1', '1', '1'), ('13', '267', '1', '1', '1'), ('13', '268', '1', '1', '1'), ('13', '276', '1', '1', '1'), ('13', '269', '0', '0', '0'), ('13', '270', '0', '0', '0'), ('13', '272', '0', '0', '0'), ('13', '271', '0', '0', '0'), ('13', '273', '0', '0', '0'), ('13', '274', '0', '0', '0'), ('13', '275', '0', '0', '0'), ('13', '277', '1', '1', '1'), ('31', '259', '1', '1', '1'), ('31', '260', '1', '1', '1'), ('31', '261', '0', '0', '0'), ('31', '262', '1', '1', '1'), ('31', '264', '1', '1', '1'), ('31', '265', '1', '1', '1'), ('31', '266', '1', '1', '1'), ('31', '267', '1', '1', '1'), ('31', '268', '1', '1', '1'), ('31', '276', '1', '1', '1'), ('31', '269', '0', '0', '0'), ('31', '270', '0', '0', '0'), ('31', '272', '0', '0', '0'), ('31', '271', '0', '0', '0'), ('31', '273', '0', '0', '0'), ('31', '274', '0', '0', '0'), ('31', '275', '0', '0', '0'), ('31', '277', '1', '1', '1'), ('32', '259', '1', '1', '1'), ('32', '260', '1', '1', '1'), ('32', '261', '0', '0', '0'), ('32', '262', '1', '1', '1'), ('32', '264', '1', '1', '1'), ('32', '265', '1', '1', '1'), ('32', '266', '1', '1', '1'), ('32', '267', '1', '1', '1'), ('32', '268', '1', '1', '1'), ('32', '276', '1', '1', '1'), ('32', '269', '0', '0', '0'), ('32', '270', '0', '0', '0'), ('32', '272', '0', '0', '0'), ('32', '271', '0', '0', '0'), ('32', '273', '0', '0', '0'), ('32', '274', '0', '0', '0'), ('32', '275', '0', '0', '0'), ('32', '277', '1', '1', '1'), ('33', '259', '1', '1', '1'), ('33', '260', '1', '1', '1'), ('33', '261', '0', '0', '0'), ('33', '262', '1', '1', '1'), ('33', '264', '1', '1', '1'), ('33', '265', '1', '1', '1'), ('33', '266', '1', '1', '1'), ('33', '267', '1', '1', '1'), ('33', '268', '1', '1', '1'), ('33', '276', '1', '1', '1'), ('33', '269', '0', '0', '0'), ('33', '270', '0', '0', '0'), ('33', '272', '0', '0', '0'), ('33', '271', '0', '0', '0'), ('33', '273', '0', '0', '0'), ('33', '274', '0', '0', '0'), ('33', '275', '0', '0', '0'), ('33', '277', '1', '1', '1'), ('34', '259', '1', '1', '1'), ('34', '260', '1', '1', '1'), ('34', '261', '0', '0', '0'), ('34', '262', '1', '1', '1'), ('34', '264', '1', '1', '1'), ('34', '265', '1', '1', '1'), ('34', '266', '1', '1', '1'), ('34', '267', '1', '1', '1'), ('34', '268', '1', '1', '1'), ('34', '276', '1', '1', '1'), ('34', '269', '0', '0', '0'), ('34', '270', '0', '0', '0'), ('34', '272', '0', '0', '0'), ('34', '271', '0', '0', '0'), ('34', '273', '0', '0', '0'), ('34', '274', '0', '0', '0'), ('34', '275', '0', '0', '0'), ('34', '277', '1', '1', '1'), ('35', '259', '1', '1', '1'), ('35', '260', '1', '1', '1'), ('35', '261', '0', '0', '0'), ('35', '262', '1', '1', '1'), ('35', '264', '1', '1', '1'), ('35', '265', '1', '1', '1'), ('35', '266', '1', '1', '1'), ('35', '267', '1', '1', '1'), ('35', '268', '1', '1', '1'), ('35', '276', '1', '1', '1'), ('35', '269', '0', '0', '0'), ('35', '270', '0', '0', '0'), ('35', '272', '0', '0', '0'), ('35', '271', '0', '0', '0'), ('35', '273', '0', '0', '0'), ('35', '274', '0', '0', '0'), ('35', '275', '0', '0', '0'), ('35', '277', '1', '1', '1'), ('36', '259', '1', '1', '1'), ('36', '260', '1', '1', '1'), ('36', '261', '0', '0', '0'), ('36', '262', '1', '1', '1'), ('36', '264', '1', '1', '1'), ('36', '265', '1', '1', '1'), ('36', '266', '1', '1', '1'), ('36', '267', '1', '1', '1'), ('36', '268', '1', '1', '1'), ('36', '276', '1', '1', '1'), ('36', '269', '0', '0', '0'), ('36', '270', '0', '0', '0'), ('36', '272', '0', '0', '0'), ('36', '271', '0', '0', '0'), ('36', '273', '0', '0', '0'), ('36', '274', '0', '0', '0'), ('36', '275', '0', '0', '0'), ('36', '277', '1', '1', '1'), ('37', '259', '1', '1', '1'), ('37', '260', '1', '1', '1'), ('37', '261', '0', '0', '0'), ('37', '262', '1', '1', '1'), ('37', '264', '1', '1', '1'), ('37', '265', '1', '1', '1'), ('37', '266', '1', '1', '1'), ('37', '267', '1', '1', '1'), ('37', '268', '1', '1', '1'), ('37', '276', '1', '1', '1'), ('37', '269', '0', '0', '0'), ('37', '270', '0', '0', '0'), ('37', '272', '0', '0', '0'), ('37', '271', '0', '0', '0'), ('37', '273', '0', '0', '0'), ('37', '274', '0', '0', '0'), ('37', '275', '0', '0', '0'), ('37', '277', '1', '1', '1'), ('38', '259', '1', '1', '1'), ('38', '260', '1', '1', '1'), ('38', '261', '0', '0', '0'), ('38', '262', '1', '1', '1'), ('38', '264', '1', '1', '1'), ('38', '265', '1', '1', '1'), ('38', '266', '1', '1', '1'), ('38', '267', '1', '1', '1'), ('38', '268', '1', '1', '1'), ('38', '276', '1', '1', '1'), ('38', '269', '0', '0', '0'), ('38', '270', '0', '0', '0'), ('38', '272', '0', '0', '0'), ('38', '271', '0', '0', '0'), ('38', '273', '0', '0', '0'), ('38', '274', '0', '0', '0'), ('38', '275', '0', '0', '0'), ('38', '277', '1', '1', '1'), ('39', '259', '1', '1', '1'), ('39', '260', '1', '1', '1'), ('39', '261', '0', '0', '0'), ('39', '262', '1', '1', '1'), ('39', '264', '1', '1', '1'), ('39', '265', '1', '1', '1'), ('39', '266', '1', '1', '1'), ('39', '267', '1', '1', '1'), ('39', '268', '1', '1', '1'), ('39', '276', '1', '1', '1'), ('39', '269', '0', '0', '0'), ('39', '270', '0', '0', '0'), ('39', '272', '0', '0', '0'), ('39', '271', '0', '0', '0'), ('39', '273', '0', '0', '0'), ('39', '274', '0', '0', '0'), ('39', '275', '0', '0', '0'), ('39', '277', '1', '1', '1'), ('40', '259', '1', '1', '1'), ('40', '260', '1', '1', '1'), ('40', '261', '0', '0', '0'), ('40', '262', '1', '1', '1'), ('40', '264', '1', '1', '1'), ('40', '265', '1', '1', '1'), ('40', '266', '1', '1', '1'), ('40', '267', '1', '1', '1'), ('40', '268', '1', '1', '1'), ('40', '276', '1', '1', '1'), ('40', '269', '0', '0', '0'), ('40', '270', '0', '0', '0'), ('40', '272', '0', '0', '0'), ('40', '271', '0', '0', '0'), ('40', '273', '0', '0', '0'), ('40', '274', '0', '0', '0'), ('40', '275', '0', '0', '0'), ('40', '277', '1', '1', '1'), ('14', '259', '1', '1', '1'), ('14', '260', '1', '1', '1'), ('14', '261', '0', '0', '0'), ('14', '262', '1', '1', '1'), ('14', '264', '1', '1', '1'), ('14', '265', '1', '1', '1'), ('14', '266', '1', '1', '1'), ('14', '267', '1', '1', '1'), ('14', '268', '1', '1', '1'), ('14', '276', '1', '1', '1'), ('14', '269', '0', '0', '0'), ('14', '270', '0', '0', '0'), ('14', '272', '0', '0', '0'), ('14', '271', '0', '0', '0'), ('14', '273', '0', '0', '0'), ('14', '274', '0', '0', '0'), ('14', '275', '0', '0', '0'), ('14', '277', '1', '1', '1'), ('41', '259', '1', '1', '1'), ('41', '260', '1', '1', '1'), ('41', '261', '0', '0', '0'), ('41', '262', '1', '1', '1'), ('41', '264', '1', '1', '1'), ('41', '265', '1', '1', '1'), ('41', '266', '1', '1', '1'), ('41', '267', '1', '1', '1'), ('41', '268', '1', '1', '1'), ('41', '276', '1', '1', '1'), ('41', '269', '0', '0', '0'), ('41', '270', '0', '0', '0'), ('41', '272', '0', '0', '0'), ('41', '271', '0', '0', '0'), ('41', '273', '0', '0', '0'), ('41', '274', '0', '0', '0'), ('41', '275', '0', '0', '0'), ('41', '277', '1', '1', '1'), ('15', '259', '1', '1', '1'), ('15', '260', '1', '1', '1'), ('15', '261', '0', '0', '0'), ('15', '262', '1', '1', '1'), ('15', '264', '1', '1', '1'), ('15', '265', '1', '1', '1'), ('15', '266', '1', '1', '1'), ('15', '267', '1', '1', '1'), ('15', '268', '1', '1', '1'), ('15', '276', '1', '1', '1'), ('15', '269', '0', '0', '0'), ('15', '270', '0', '0', '0'), ('15', '272', '0', '0', '0'), ('15', '271', '0', '0', '0'), ('15', '273', '0', '0', '0'), ('15', '274', '0', '0', '0'), ('15', '275', '0', '0', '0'), ('15', '277', '1', '1', '1'), ('16', '259', '1', '1', '1'), ('16', '260', '1', '1', '1'), ('16', '261', '0', '0', '0'), ('16', '262', '1', '1', '1'), ('16', '264', '1', '1', '1'), ('16', '265', '1', '1', '1'), ('16', '266', '1', '1', '1'), ('16', '267', '1', '1', '1'), ('16', '268', '1', '1', '1'), ('16', '276', '1', '1', '1'), ('16', '269', '0', '0', '0'), ('16', '270', '0', '0', '0'), ('16', '272', '0', '0', '0'), ('16', '271', '0', '0', '0'), ('16', '273', '0', '0', '0'), ('16', '274', '0', '0', '0'), ('16', '275', '0', '0', '0'), ('16', '277', '1', '1', '1'), ('17', '259', '1', '1', '1'), ('17', '260', '1', '1', '1'), ('17', '261', '0', '0', '0'), ('17', '262', '1', '1', '1'), ('17', '264', '1', '1', '1'), ('17', '265', '1', '1', '1'), ('17', '266', '1', '1', '1'), ('17', '267', '1', '1', '1'), ('17', '268', '1', '1', '1'), ('17', '276', '1', '1', '1'), ('17', '269', '0', '0', '0'), ('17', '270', '0', '0', '0'), ('17', '272', '0', '0', '0'), ('17', '271', '0', '0', '0'), ('17', '273', '0', '0', '0'), ('17', '274', '0', '0', '0'), ('17', '275', '0', '0', '0'), ('17', '277', '1', '1', '1'), ('17', '259', '1', '1', '1'), ('17', '260', '1', '1', '1'), ('17', '261', '0', '0', '0'), ('17', '262', '1', '1', '1'), ('17', '264', '1', '1', '1'), ('17', '265', '1', '1', '1'), ('17', '266', '1', '1', '1'), ('17', '267', '1', '1', '1'), ('17', '268', '1', '1', '1'), ('17', '276', '1', '1', '1'), ('17', '269', '0', '0', '0'), ('17', '270', '0', '0', '0'), ('17', '272', '0', '0', '0'), ('17', '271', '0', '0', '0'), ('17', '273', '0', '0', '0'), ('17', '274', '0', '0', '0'), ('17', '275', '0', '0', '0'), ('17', '277', '1', '1', '1'), ('18', '259', '1', '1', '1'), ('18', '260', '1', '1', '1'), ('18', '261', '0', '0', '0'), ('18', '262', '1', '1', '1'), ('18', '264', '1', '1', '1'), ('18', '265', '1', '1', '1'), ('18', '266', '1', '1', '1'), ('18', '267', '1', '1', '1'), ('18', '268', '1', '1', '1'), ('18', '276', '1', '1', '1'), ('18', '269', '0', '0', '0'), ('18', '270', '0', '0', '0'), ('18', '272', '0', '0', '0'), ('18', '271', '0', '0', '0'), ('18', '273', '0', '0', '0'), ('18', '274', '0', '0', '0'), ('18', '275', '0', '0', '0'), ('18', '277', '1', '1', '1'), ('19', '259', '1', '1', '1'), ('19', '260', '1', '1', '1'), ('19', '261', '0', '0', '0'), ('19', '262', '1', '1', '1'), ('19', '264', '1', '1', '1'), ('19', '265', '1', '1', '1'), ('19', '266', '1', '1', '1'), ('19', '267', '1', '1', '1'), ('19', '268', '1', '1', '1'), ('19', '276', '1', '1', '1'), ('19', '269', '0', '0', '0'), ('19', '270', '0', '0', '0'), ('19', '272', '0', '0', '0'), ('19', '271', '0', '0', '0'), ('19', '273', '0', '0', '0'), ('19', '274', '0', '0', '0'), ('19', '275', '0', '0', '0'), ('19', '277', '1', '1', '1'), ('20', '259', '1', '1', '1'), ('20', '260', '1', '1', '1'), ('20', '261', '0', '0', '0'), ('20', '262', '1', '1', '1'), ('20', '264', '1', '1', '1'), ('20', '265', '1', '1', '1'), ('20', '266', '1', '1', '1'), ('20', '267', '1', '1', '1'), ('20', '268', '1', '1', '1'), ('20', '276', '1', '1', '1'), ('20', '269', '0', '0', '0'), ('20', '270', '0', '0', '0'), ('20', '272', '0', '0', '0'), ('20', '271', '0', '0', '0'), ('20', '273', '0', '0', '0'), ('20', '274', '0', '0', '0'), ('20', '275', '0', '0', '0'), ('20', '277', '1', '1', '1'), ('42', '259', '1', '1', '1'), ('42', '260', '1', '1', '1'), ('42', '261', '0', '0', '0'), ('42', '262', '1', '1', '1'), ('42', '264', '1', '1', '1'), ('42', '265', '1', '1', '1'), ('42', '266', '1', '1', '1'), ('42', '267', '1', '1', '1'), ('42', '268', '1', '1', '1'), ('42', '276', '1', '1', '1'), ('42', '269', '0', '0', '0'), ('42', '270', '0', '0', '0'), ('42', '272', '0', '0', '0'), ('42', '271', '0', '0', '0'), ('42', '273', '0', '0', '0'), ('42', '274', '0', '0', '0'), ('42', '275', '0', '0', '0'), ('42', '277', '1', '1', '1'), ('43', '259', '1', '1', '1'), ('43', '260', '1', '1', '1'), ('43', '261', '0', '0', '0'), ('43', '262', '1', '1', '1'), ('43', '264', '1', '1', '1'), ('43', '265', '1', '1', '1'), ('43', '266', '1', '1', '1'), ('43', '267', '1', '1', '1'), ('43', '268', '1', '1', '1'), ('43', '276', '1', '1', '1'), ('43', '269', '0', '0', '0'), ('43', '270', '0', '0', '0'), ('43', '272', '0', '0', '0'), ('43', '271', '0', '0', '0'), ('43', '273', '0', '0', '0'), ('43', '274', '0', '0', '0'), ('43', '275', '0', '0', '0'), ('43', '277', '1', '1', '1'), ('44', '259', '1', '1', '1'), ('44', '260', '1', '1', '1'), ('44', '261', '0', '0', '0'), ('44', '262', '1', '1', '1'), ('44', '264', '1', '1', '1'), ('44', '265', '1', '1', '1'), ('44', '266', '1', '1', '1'), ('44', '267', '1', '1', '1'), ('44', '268', '1', '1', '1'), ('44', '276', '1', '1', '1'), ('44', '269', '0', '0', '0'), ('44', '270', '0', '0', '0'), ('44', '272', '0', '0', '0'), ('44', '271', '0', '0', '0'), ('44', '273', '0', '0', '0'), ('44', '274', '0', '0', '0'), ('44', '275', '0', '0', '0'), ('44', '277', '1', '1', '1'), ('45', '259', '1', '1', '1'), ('45', '260', '1', '1', '1'), ('45', '261', '0', '0', '0'), ('45', '262', '1', '1', '1'), ('45', '264', '1', '1', '1'), ('45', '265', '1', '1', '1'), ('45', '266', '1', '1', '1'), ('45', '267', '1', '1', '1'), ('45', '268', '1', '1', '1'), ('45', '276', '1', '1', '1'), ('45', '269', '0', '0', '0'), ('45', '270', '0', '0', '0'), ('45', '272', '0', '0', '0'), ('45', '271', '0', '0', '0'), ('45', '273', '0', '0', '0'), ('45', '274', '0', '0', '0'), ('45', '275', '0', '0', '0'), ('45', '277', '1', '1', '1'), ('45', '259', '1', '1', '1'), ('45', '260', '1', '1', '1'), ('45', '261', '0', '0', '0'), ('45', '262', '1', '1', '1'), ('45', '264', '1', '1', '1'), ('45', '265', '1', '1', '1'), ('45', '266', '1', '1', '1'), ('45', '267', '1', '1', '1'), ('45', '268', '1', '1', '1'), ('45', '276', '1', '1', '1'), ('45', '269', '0', '0', '0'), ('45', '270', '0', '0', '0'), ('45', '272', '0', '0', '0'), ('45', '271', '0', '0', '0'), ('45', '273', '0', '0', '0'), ('45', '274', '0', '0', '0'), ('45', '275', '0', '0', '0'), ('45', '277', '1', '1', '1'), ('10', '253', '0', '1', '1'), ('10', '87', '0', '1', '1'), ('10', '144', '0', '1', '1'), ('10', '149', '0', '0', '0'), ('10', '150', '0', '0', '0'), ('10', '147', '0', '0', '0'), ('10', '148', '0', '0', '0'), ('10', '258', '0', '0', '0'), ('10', '278', '0', '0', '0'), ('10', '88', '0', '1', '0'), ('10', '126', '0', '1', '0'), ('10', '198', '0', '0', '0'), ('10', '191', '0', '0', '0'), ('10', '193', '0', '0', '0'), ('10', '192', '0', '1', '0'), ('1', '253', null, '1', null), ('1', '87', null, '1', '1'), ('1', '144', null, '1', '1'), ('1', '149', null, null, null), ('1', '150', null, null, null), ('1', '147', null, null, null), ('1', '148', null, null, null), ('1', '278', null, null, null), ('1', '258', null, null, null), ('1', '185', null, null, null), ('1', '88', null, '1', '1'), ('1', '126', null, '1', '1'), ('1', '219', null, null, null), ('1', '220', null, null, null), ('1', '189', null, null, null), ('1', '191', null, null, null), ('1', '192', null, '1', '1'), ('1', '193', null, null, null), ('46', '253', '1', '1', '1'), ('46', '87', null, '1', '1'), ('46', '144', null, '1', '1'), ('46', '149', null, null, null), ('46', '150', null, null, null), ('46', '147', null, null, null), ('46', '148', null, null, null), ('46', '278', null, null, null), ('46', '258', null, null, null), ('46', '84', null, null, null), ('46', '110', null, null, null), ('46', '115', null, '1', null), ('46', '116', null, '1', '1'), ('46', '113', null, null, null), ('46', '279', null, null, null), ('56', '198', '1', '1', '1'), ('56', '280', '1', '1', '1'), ('2', '253', null, '1', null), ('2', '87', null, '1', '1'), ('2', '144', null, '1', '1'), ('2', '149', null, null, null), ('2', '150', null, null, null), ('2', '147', null, null, null), ('2', '148', null, null, null), ('2', '258', null, null, null), ('2', '278', null, null, null), ('2', '88', null, '1', null), ('2', '126', null, '1', null), ('2', '279', null, null, null), ('2', '84', null, '1', '1'), ('2', '110', null, null, null), ('2', '115', '1', '1', '1'), ('2', '116', '1', '1', '1'), ('47', '253', null, '1', null), ('47', '87', null, '1', '1'), ('47', '144', null, '1', '1'), ('47', '149', null, null, null), ('47', '150', null, null, null), ('47', '147', null, null, null), ('47', '148', null, null, null), ('47', '258', null, null, null), ('47', '278', null, null, null), ('47', '198', null, '1', null), ('47', '191', null, null, null), ('47', '193', null, null, null), ('53', '253', null, null, null), ('53', '87', null, '1', '1'), ('53', '144', null, '1', '1'), ('53', '149', null, null, null), ('53', '150', null, null, null), ('53', '147', null, null, null), ('53', '148', null, null, null), ('53', '258', null, null, null), ('53', '278', null, null, null), ('53', '88', null, '1', null), ('53', '126', null, '1', null), ('53', '198', null, '1', null), ('53', '191', null, null, null), ('53', '192', null, null, null), ('53', '193', null, null, null), ('52', '253', null, null, null), ('52', '87', null, '1', '1'), ('52', '144', null, '1', '1'), ('52', '149', null, null, null), ('52', '150', null, null, null), ('52', '147', null, null, null), ('52', '148', null, null, null), ('52', '258', null, null, null), ('52', '278', null, null, null), ('52', '88', null, '1', null), ('52', '126', null, '1', null), ('52', '198', null, '1', null), ('52', '191', null, null, null), ('52', '192', null, null, null), ('52', '193', null, null, null), ('54', '253', null, '1', null), ('54', '87', null, '1', '1'), ('54', '144', null, '1', '1'), ('54', '149', null, null, null), ('54', '150', null, null, null), ('54', '147', null, null, null), ('54', '148', null, null, null), ('54', '258', null, null, null), ('54', '278', null, null, null), ('54', '88', null, '1', null), ('54', '126', null, '1', null), ('54', '198', null, '1', null), ('54', '191', null, null, null), ('54', '192', null, null, null), ('54', '193', null, null, null), ('7', '192', null, '1', null), ('7', '253', null, '1', '1'), ('7', '87', null, '1', '1'), ('7', '144', null, '1', '1'), ('7', '149', null, null, null), ('7', '150', null, null, null), ('7', '147', null, null, null), ('7', '148', null, null, null), ('7', '258', null, null, null), ('7', '278', null, null, null), ('7', '88', null, '1', null), ('7', '126', null, '1', null), ('7', '198', null, '1', null), ('7', '191', null, null, null), ('7', '192', null, '1', null), ('7', '193', null, null, null), ('8', '281', null, null, null), ('8', '253', '1', '1', '1'), ('8', '85', '1', '1', '1'), ('8', '100', null, null, null), ('8', '101', null, null, null), ('8', '106', null, null, null), ('8', '104', null, null, null), ('8', '105', null, null, null), ('8', '107', null, null, null), ('8', '177', '1', '1', '1'), ('8', '102', null, null, null), ('8', '143', '1', '1', '1'), ('8', '108', '1', '1', '1'), ('8', '124', null, null, null), ('8', '87', '1', '1', '1'), ('8', '144', '1', '1', '1'), ('8', '149', null, null, null), ('8', '150', null, null, null), ('8', '147', null, null, null), ('8', '148', null, null, null), ('8', '258', null, null, null), ('8', '278', null, null, null), ('8', '234', null, null, null), ('8', '184', null, null, null), ('8', '185', null, null, null), ('8', '146', '1', '1', '1'), ('8', '254', '1', '1', '1'), ('8', '257', null, null, null), ('8', '255', '1', '1', '1'), ('8', '256', null, null, null), ('8', '88', '1', '1', '1'), ('8', '126', '1', '1', '1'), ('8', '219', null, null, null), ('8', '220', null, null, null), ('8', '189', null, null, null), ('8', '221', '1', '1', '1'), ('8', '222', null, null, null), ('8', '226', '1', '1', '1'), ('8', '227', null, null, null), ('8', '228', null, null, null), ('8', '217', '1', '1', '1'), ('8', '216', '1', '1', '1'), ('8', '252', '1', '1', '1'), ('8', '214', '1', '1', '1'), ('8', '279', null, null, null), ('8', '157', '1', '1', '1'), ('8', '169', '1', '1', '1'), ('8', '156', '1', '1', '1'), ('8', '158', '1', '1', '1'), ('8', '229', '1', '1', '1'), ('8', '259', '1', '1', '1'), ('8', '260', '1', '1', '1'), ('8', '261', null, null, null), ('8', '262', '1', '1', '1'), ('8', '264', '1', '1', '1'), ('8', '265', '1', '1', '1'), ('8', '266', '1', '1', '1'), ('8', '267', '1', '1', '1'), ('8', '268', '1', '1', '1'), ('8', '269', null, null, null), ('8', '270', null, null, null), ('8', '272', null, null, null), ('8', '271', null, null, null), ('8', '273', null, null, null), ('8', '274', null, null, null), ('8', '275', null, null, null), ('8', '276', '1', '1', '1'), ('8', '277', '1', '1', '1'), ('8', '198', '1', '1', '1'), ('8', '280', '1', '1', '1'), ('8', '190', '1', '1', '1'), ('8', '125', '1', '1', '1'), ('8', '91', '1', '1', '1'), ('8', '152', '1', '1', '1'), ('8', '191', null, null, null), ('8', '192', '1', '1', '1'), ('8', '193', null, null, null), ('8', '194', '1', '1', '1'), ('8', '84', '1', '1', '1'), ('8', '110', null, null, null), ('8', '115', '1', '1', '1'), ('8', '123', '1', '1', '1'), ('8', '153', '1', '1', '1'), ('8', '116', '1', '1', '1'), ('8', '112', null, null, null), ('8', '118', '1', '1', '1'), ('8', '119', null, null, null), ('8', '120', null, null, null), ('8', '205', '1', '1', '1'), ('8', '206', null, null, null), ('8', '113', null, null, null), ('8', '121', '1', '1', '1'), ('8', '114', '1', '1', '1'), ('9', '253', null, '1', '1'), ('9', '87', null, '1', '1'), ('9', '144', null, '1', '1'), ('9', '149', null, null, null), ('9', '150', null, null, null), ('9', '147', null, null, null), ('9', '148', null, null, null), ('9', '278', null, null, null), ('9', '258', null, null, null), ('9', '88', null, '1', null), ('9', '126', null, '1', null), ('9', '198', null, '1', null), ('9', '191', null, null, null), ('9', '193', null, null, null), ('9', '192', null, '1', null), ('48', '253', null, '1', null), ('48', '87', null, '1', '1'), ('48', '144', null, '1', '1'), ('48', '149', null, null, null), ('48', '150', null, null, null), ('48', '147', null, null, null), ('48', '148', null, null, null), ('48', '278', null, null, null), ('48', '258', null, null, null), ('48', '88', null, '1', null), ('48', '126', null, '1', null), ('48', '198', null, '1', null), ('48', '191', null, null, null), ('48', '193', null, null, null), ('48', '192', null, '1', null), ('49', '253', null, '1', null), ('49', '87', null, '1', '1'), ('49', '144', null, '1', '1'), ('49', '149', null, null, null), ('49', '150', null, null, null), ('49', '147', null, null, null), ('49', '148', null, null, null), ('49', '278', null, null, null), ('49', '258', null, null, null), ('49', '88', null, '1', null), ('49', '126', null, '1', null), ('49', '198', null, '1', null), ('49', '191', null, null, null), ('49', '193', null, null, null), ('49', '192', null, '1', null), ('50', '253', null, '1', '1'), ('50', '87', null, '1', '1'), ('50', '144', null, '1', '1'), ('50', '149', null, null, null), ('50', '150', null, null, null), ('50', '147', null, null, null), ('50', '148', null, null, null), ('50', '278', null, null, null), ('50', '258', null, null, null), ('50', '88', null, '1', null), ('50', '126', null, '1', null), ('50', '198', null, '1', null), ('50', '191', null, null, null), ('50', '193', null, null, null), ('50', '192', null, '1', null), ('51', '253', null, '1', null), ('51', '87', null, '1', '1'), ('51', '144', null, '1', '1'), ('51', '149', null, null, null), ('51', '150', null, null, null), ('51', '147', null, null, null), ('51', '148', null, null, null), ('51', '278', null, null, null), ('51', '258', null, null, null), ('51', '88', null, '1', null), ('51', '126', null, '1', null), ('51', '198', null, '1', null), ('51', '191', null, null, null), ('51', '193', null, null, null), ('51', '192', null, '1', null), ('55', '253', null, null, null), ('55', '87', null, '1', '1'), ('55', '144', null, '1', '1'), ('55', '149', null, null, null), ('55', '150', null, null, null), ('55', '147', null, null, null), ('55', '148', null, null, null), ('55', '278', null, null, null), ('55', '258', null, null, null), ('55', '88', null, '1', null), ('55', '126', null, '1', null), ('55', '198', null, '1', null), ('55', '191', null, null, null), ('55', '193', null, null, null), ('55', '192', null, null, null), ('57', '253', null, null, null), ('57', '87', null, '1', '1'), ('57', '144', null, '1', '1'), ('57', '149', null, null, null), ('57', '150', null, null, null), ('57', '147', null, null, null), ('57', '148', null, null, null), ('57', '278', null, null, null), ('57', '258', null, null, null), ('57', '88', null, '1', null), ('57', '126', null, '1', null), ('57', '198', null, '1', null), ('57', '191', null, null, null), ('57', '193', null, null, null), ('57', '192', null, null, null), ('58', '253', null, '1', '1'), ('58', '87', null, '1', '1'), ('58', '144', null, '1', '1'), ('58', '149', null, null, null), ('58', '150', null, null, null), ('58', '147', null, null, null), ('58', '148', null, null, null), ('58', '278', null, null, null), ('58', '258', null, null, null), ('58', '88', null, '1', null), ('58', '126', null, '1', null), ('58', '219', null, null, null), ('58', '191', null, null, null), ('58', '193', null, null, null), ('58', '192', null, '1', null), ('59', '281', null, null, null), ('59', '198', null, null, null), ('59', '191', null, null, null), ('59', '193', null, null, null), ('59', '192', null, '1', null);
INSERT INTO `think_role_duty` VALUES ('10', '17'), ('46', '18'), ('47', '18'), ('7', '14'), ('7', '19'), ('48', '14'), ('48', '20'), ('49', '14'), ('49', '21'), ('50', '15'), ('50', '23'), ('51', '15'), ('51', '24'), ('9', '15'), ('9', '22'), ('1', '15'), ('1', '22'), ('52', '14'), ('52', '25'), ('53', '14'), ('53', '26'), ('54', '14'), ('54', '27'), ('55', '15'), ('55', '28'), ('57', '14'), ('57', '29'), ('8', '14'), ('8', '15'), ('8', '17'), ('8', '19'), ('8', '20'), ('8', '21'), ('8', '22'), ('8', '23'), ('8', '24'), ('8', '25'), ('8', '26'), ('8', '27'), ('8', '28'), ('8', '29'), ('58', '31');
INSERT INTO `think_role_user` VALUES ('7', '2'), ('7', '5'), ('7', '6'), ('7', '7'), ('7', '8'), ('7', '9'), ('7', '10'), ('48', '11'), ('7', '12'), ('7', '15'), ('7', '16'), ('7', '17'), ('7', '18'), ('7', '19'), ('7', '20'), ('7', '21'), ('7', '22'), ('7', '23'), ('9', '24'), ('7', '25'), ('7', '26'), ('7', '27'), ('7', '28'), ('7', '29'), ('7', '30'), ('7', '31'), ('7', '32'), ('7', '33'), ('7', '34'), ('7', '35'), ('7', '36'), ('7', '37'), ('7', '38'), ('7', '39'), ('7', '40'), ('7', '41'), ('7', '42'), ('7', '43'), ('7', '44'), ('7', '45'), ('7', '46'), ('7', '47'), ('48', '48'), ('7', '49'), ('7', '50'), ('7', '51'), ('7', '52'), ('7', '53'), ('48', '54'), ('7', '56'), ('7', '57'), ('7', '58'), ('7', '59'), ('7', '60'), ('7', '61'), ('7', '63'), ('48', '64'), ('48', '65'), ('7', '66'), ('7', '67'), ('48', '68'), ('7', '69'), ('51', '70'), ('7', '71'), ('7', '72'), ('7', '73'), ('7', '74'), ('7', '75'), ('7', '76'), ('7', '78'), ('7', '79'), ('48', '80'), ('7', '81'), ('7', '82'), ('7', '83'), ('7', '84'), ('7', '85'), ('7', '86'), ('7', '87'), ('7', '88'), ('7', '89'), ('7', '90'), ('7', '91'), ('7', '92'), ('7', '93'), ('7', '94'), ('7', '95'), ('7', '96'), ('7', '97'), ('7', '98'), ('7', '99'), ('7', '100'), ('7', '101'), ('7', '102'), ('48', '103'), ('7', '104'), ('7', '105'), ('7', '106'), ('7', '107'), ('7', '108'), ('7', '109'), ('7', '110'), ('7', '111'), ('7', '112'), ('7', '113'), ('7', '114'), ('7', '115'), ('7', '117'), ('7', '118'), ('7', '119'), ('7', '120'), ('7', '122'), ('7', '123'), ('7', '124'), ('7', '125'), ('7', '126'), ('48', '127'), ('48', '128'), ('9', '129'), ('7', '130'), ('7', '131'), ('7', '132'), ('7', '134'), ('7', '135'), ('7', '136'), ('7', '137'), ('48', '138'), ('7', '139'), ('7', '140'), ('7', '141'), ('48', '142'), ('7', '143'), ('7', '144'), ('7', '145'), ('7', '146'), ('7', '147'), ('7', '148'), ('7', '149'), ('7', '150'), ('7', '151'), ('7', '152'), ('7', '153'), ('7', '154'), ('48', '155'), ('49', '156'), ('7', '157'), ('48', '158'), ('7', '159'), ('7', '160'), ('7', '161'), ('50', '162'), ('7', '163'), ('7', '164'), ('7', '165'), ('7', '166'), ('7', '167'), ('7', '168'), ('7', '169'), ('7', '170'), ('48', '171'), ('7', '172'), ('7', '173'), ('7', '174'), ('7', '175'), ('48', '176'), ('7', '177'), ('7', '178'), ('7', '179'), ('7', '180'), ('7', '181'), ('7', '182'), ('7', '183'), ('7', '184'), ('7', '185'), ('7', '186'), ('7', '187'), ('7', '188'), ('7', '189'), ('7', '190'), ('7', '191'), ('48', '194'), ('7', '195'), ('7', '196'), ('7', '197'), ('7', '198'), ('7', '199'), ('7', '200'), ('7', '201'), ('7', '202'), ('7', '203'), ('7', '204'), ('49', '205'), ('7', '206'), ('7', '207'), ('7', '208'), ('7', '209'), ('7', '210'), ('7', '211'), ('7', '212'), ('7', '213'), ('7', '214'), ('7', '215'), ('7', '216'), ('7', '217'), ('7', '218'), ('7', '219'), ('7', '220'), ('7', '221'), ('7', '222'), ('7', '223'), ('7', '224'), ('7', '225'), ('48', '226'), ('7', '227'), ('7', '228'), ('7', '229'), ('49', '230'), ('7', '231'), ('7', '232'), ('7', '233'), ('7', '234'), ('48', '235'), ('7', '236'), ('7', '237'), ('7', '238'), ('7', '239'), ('7', '240'), ('7', '241'), ('7', '242'), ('7', '244'), ('7', '245'), ('7', '246'), ('7', '247'), ('7', '248'), ('7', '249'), ('7', '250'), ('7', '251'), ('7', '252'), ('7', '253'), ('7', '254'), ('7', '255'), ('7', '257'), ('48', '258'), ('7', '259'), ('7', '260'), ('7', '261'), ('7', '262'), ('7', '263'), ('7', '264'), ('7', '265'), ('7', '267'), ('7', '268'), ('7', '269'), ('7', '270'), ('7', '271'), ('7', '272'), ('7', '273'), ('7', '274'), ('7', '275'), ('7', '276'), ('7', '277'), ('48', '278'), ('7', '279'), ('7', '280'), ('48', '281'), ('7', '282'), ('7', '283'), ('7', '284'), ('7', '285'), ('7', '286'), ('7', '287'), ('7', '289'), ('7', '290'), ('7', '291'), ('7', '292'), ('7', '293'), ('7', '294'), ('7', '296'), ('7', '297'), ('7', '298'), ('7', '299'), ('7', '300'), ('7', '301'), ('48', '302'), ('7', '303'), ('7', '304'), ('7', '305'), ('7', '306'), ('7', '307'), ('7', '308'), ('7', '309'), ('7', '310'), ('7', '311'), ('7', '312'), ('7', '313'), ('7', '314'), ('7', '315'), ('7', '316'), ('7', '317'), ('7', '318'), ('7', '319'), ('7', '320'), ('9', '321'), ('7', '322'), ('9', '323'), ('7', '324'), ('7', '325'), ('7', '326'), ('7', '327'), ('48', '328'), ('7', '329'), ('48', '330'), ('7', '331'), ('9', '332'), ('7', '333'), ('7', '334'), ('7', '335'), ('7', '336'), ('7', '337'), ('7', '338'), ('48', '339'), ('7', '340'), ('7', '341'), ('7', '342'), ('7', '343'), ('48', '344'), ('7', '345'), ('7', '346'), ('7', '347'), ('7', '348'), ('7', '349'), ('7', '350'), ('7', '351'), ('7', '352'), ('7', '353'), ('48', '354'), ('9', '355'), ('7', '356'), ('7', '357'), ('7', '358'), ('7', '359'), ('7', '360'), ('7', '361'), ('7', '362'), ('7', '364'), ('7', '365'), ('7', '366'), ('7', '367'), ('7', '368'), ('7', '369'), ('7', '370'), ('7', '371'), ('7', '372'), ('7', '375'), ('7', '376'), ('7', '377'), ('7', '378'), ('7', '379'), ('7', '380'), ('7', '381'), ('7', '382'), ('48', '384'), ('48', '385'), ('7', '386'), ('7', '387'), ('7', '388'), ('48', '389'), ('7', '390'), ('9', '391'), ('7', '392'), ('7', '393'), ('7', '394'), ('9', '395'), ('7', '396'), ('7', '398'), ('7', '399'), ('7', '400'), ('48', '401'), ('7', '402'), ('7', '403'), ('7', '404'), ('7', '405'), ('7', '406'), ('7', '407'), ('7', '408'), ('7', '409'), ('7', '410'), ('7', '411'), ('7', '412'), ('7', '413'), ('7', '414'), ('7', '415'), ('7', '416'), ('7', '417'), ('7', '418'), ('7', '420'), ('7', '421'), ('7', '422'), ('49', '423'), ('7', '424'), ('7', '425'), ('7', '426'), ('7', '427'), ('48', '428'), ('7', '429'), ('7', '431'), ('7', '432'), ('7', '433'), ('7', '434'), ('7', '436'), ('7', '437'), ('7', '438'), ('7', '439'), ('7', '440'), ('7', '441'), ('48', '443'), ('7', '444'), ('7', '445'), ('7', '446'), ('7', '447'), ('7', '448'), ('7', '449'), ('7', '450'), ('49', '451'), ('7', '453'), ('7', '454'), ('7', '455'), ('7', '456'), ('7', '457'), ('7', '458'), ('7', '459'), ('7', '460'), ('49', '461'), ('7', '462'), ('7', '463'), ('48', '464'), ('7', '465'), ('7', '466'), ('7', '467'), ('48', '468'), ('7', '469'), ('7', '470'), ('7', '471'), ('7', '472'), ('7', '473'), ('7', '474'), ('7', '475'), ('7', '476'), ('7', '477'), ('7', '478'), ('7', '479'), ('7', '480'), ('7', '481'), ('7', '482'), ('48', '483'), ('7', '484'), ('7', '485'), ('7', '486'), ('7', '487'), ('7', '488'), ('7', '489'), ('7', '490'), ('7', '491'), ('7', '492'), ('7', '493'), ('7', '494'), ('48', '495'), ('7', '496'), ('49', '497'), ('7', '498'), ('7', '499'), ('7', '500'), ('7', '501'), ('7', '502'), ('7', '503'), ('7', '504'), ('48', '505'), ('7', '507'), ('7', '508'), ('7', '509'), ('7', '510'), ('7', '511'), ('7', '512'), ('7', '513'), ('49', '515'), ('7', '517'), ('7', '518'), ('9', '519'), ('48', '520'), ('9', '521'), ('7', '522'), ('7', '523'), ('7', '524'), ('7', '525'), ('7', '526'), ('7', '527'), ('7', '528'), ('7', '529'), ('7', '530'), ('9', '531'), ('7', '532'), ('50', '533'), ('7', '534'), ('7', '535'), ('7', '536'), ('7', '537'), ('7', '538'), ('7', '539'), ('7', '540'), ('7', '541'), ('7', '542'), ('7', '543'), ('7', '544'), ('7', '545'), ('48', '546'), ('48', '547'), ('7', '548'), ('7', '549'), ('7', '550'), ('7', '551'), ('48', '552'), ('7', '553'), ('7', '554'), ('48', '555'), ('7', '556'), ('7', '557'), ('7', '558'), ('7', '559'), ('7', '560'), ('7', '561'), ('7', '562'), ('7', '563'), ('7', '564'), ('7', '565'), ('7', '566'), ('7', '568'), ('7', '569'), ('7', '570'), ('7', '571'), ('7', '572'), ('7', '573'), ('7', '575'), ('7', '576'), ('7', '577'), ('7', '578'), ('7', '579'), ('7', '580'), ('7', '581'), ('9', '582'), ('7', '583'), ('7', '584'), ('7', '585'), ('7', '587'), ('7', '588'), ('7', '589'), ('7', '590'), ('7', '591'), ('7', '592'), ('7', '593'), ('9', '594'), ('7', '595'), ('7', '596'), ('7', '597'), ('7', '598'), ('7', '599'), ('7', '600'), ('7', '601'), ('7', '602'), ('48', '603'), ('7', '604'), ('7', '605'), ('7', '606'), ('7', '607'), ('7', '608'), ('7', '609'), ('7', '610'), ('48', '611'), ('7', '612'), ('7', '613'), ('7', '614'), ('48', '615'), ('7', '617'), ('7', '618'), ('7', '619'), ('7', '620'), ('7', '621'), ('7', '622'), ('7', '623'), ('7', '624'), ('7', '625'), ('7', '626'), ('7', '627'), ('7', '628'), ('7', '629'), ('7', '630'), ('7', '631'), ('7', '632'), ('7', '633'), ('7', '634'), ('7', '635'), ('7', '636'), ('7', '637'), ('7', '638'), ('7', '639'), ('7', '641'), ('7', '642'), ('7', '643'), ('7', '644'), ('48', '645'), ('7', '646'), ('7', '647'), ('7', '648'), ('7', '650'), ('48', '651'), ('9', '652'), ('7', '653'), ('7', '654'), ('9', '655'), ('7', '656'), ('7', '657'), ('7', '658'), ('7', '659'), ('7', '660'), ('7', '661'), ('7', '662'), ('7', '663'), ('50', '666'), ('7', '667'), ('7', '668'), ('7', '669'), ('7', '670'), ('7', '671'), ('7', '672'), ('7', '673'), ('7', '674'), ('7', '675'), ('7', '676'), ('7', '677'), ('7', '679'), ('7', '680'), ('7', '681'), ('7', '682'), ('7', '683'), ('7', '684'), ('7', '685'), ('7', '686'), ('7', '687'), ('7', '688'), ('48', '689'), ('7', '690'), ('7', '691'), ('7', '692'), ('7', '693'), ('7', '694'), ('7', '695'), ('7', '696'), ('7', '698'), ('7', '699'), ('7', '700'), ('7', '701'), ('7', '702'), ('7', '704'), ('7', '705'), ('7', '706'), ('7', '708'), ('7', '709'), ('7', '710'), ('7', '711'), ('7', '713'), ('7', '714'), ('7', '715'), ('7', '716'), ('7', '717'), ('7', '718'), ('7', '719'), ('7', '720'), ('48', '721'), ('49', '722'), ('7', '724'), ('7', '725'), ('7', '726'), ('7', '727'), ('7', '728'), ('48', '729'), ('7', '730'), ('7', '731'), ('7', '732'), ('7', '733'), ('7', '735'), ('48', '736'), ('7', '737'), ('7', '738'), ('7', '739'), ('7', '740'), ('7', '741'), ('7', '742'), ('51', '743'), ('7', '744'), ('7', '745'), ('7', '746'), ('7', '747'), ('7', '748'), ('7', '749'), ('7', '750'), ('7', '751'), ('7', '752'), ('7', '753'), ('7', '754'), ('7', '755'), ('7', '756'), ('7', '757'), ('7', '758'), ('49', '759'), ('7', '760'), ('7', '761'), ('7', '762'), ('7', '763'), ('7', '764'), ('7', '765'), ('7', '766'), ('7', '767'), ('7', '768'), ('7', '769'), ('7', '770'), ('7', '771'), ('7', '772'), ('7', '773'), ('7', '774'), ('7', '775'), ('7', '776'), ('7', '777'), ('7', '778'), ('7', '779'), ('7', '780'), ('7', '781'), ('7', '782'), ('7', '783'), ('7', '784'), ('7', '785'), ('7', '786'), ('7', '787'), ('7', '788'), ('7', '789'), ('7', '790'), ('48', '792'), ('7', '793'), ('7', '794'), ('7', '795'), ('7', '796'), ('7', '797'), ('7', '798'), ('7', '799'), ('7', '800'), ('7', '802'), ('7', '803'), ('7', '804'), ('7', '806'), ('7', '807'), ('7', '808'), ('7', '809'), ('7', '810'), ('7', '812'), ('9', '813'), ('7', '814'), ('7', '815'), ('7', '816'), ('7', '817'), ('7', '818'), ('7', '819'), ('7', '820'), ('7', '821'), ('7', '822'), ('7', '823'), ('7', '824'), ('7', '825'), ('7', '826'), ('7', '827'), ('7', '828'), ('7', '829'), ('7', '830'), ('48', '831'), ('7', '833'), ('7', '834'), ('7', '835'), ('7', '836'), ('7', '837'), ('7', '840'), ('7', '841'), ('7', '842'), ('7', '843'), ('7', '844'), ('7', '845'), ('7', '846'), ('7', '847'), ('7', '848'), ('7', '849'), ('7', '850'), ('7', '851'), ('7', '852'), ('7', '853'), ('7', '854'), ('48', '855'), ('7', '856'), ('7', '857'), ('7', '858'), ('7', '860'), ('7', '862'), ('7', '863'), ('7', '864'), ('7', '865'), ('7', '866'), ('49', '867'), ('7', '868'), ('7', '869'), ('7', '870'), ('48', '872'), ('7', '873'), ('7', '874'), ('7', '875'), ('7', '876'), ('48', '877'), ('7', '878'), ('7', '879'), ('7', '880'), ('7', '881'), ('7', '882'), ('7', '883'), ('7', '884'), ('7', '885'), ('7', '886'), ('7', '887'), ('7', '888'), ('7', '889'), ('7', '890'), ('7', '891'), ('48', '892'), ('7', '893'), ('7', '894'), ('7', '895'), ('7', '896'), ('48', '897'), ('7', '898'), ('7', '899'), ('7', '900'), ('7', '901'), ('7', '902'), ('7', '903'), ('7', '904'), ('7', '905'), ('9', '906'), ('7', '907'), ('7', '908'), ('7', '909'), ('7', '910'), ('7', '911'), ('7', '912'), ('7', '913'), ('7', '914'), ('7', '915'), ('7', '916'), ('7', '917'), ('7', '918'), ('7', '919'), ('7', '920'), ('48', '922'), ('7', '923'), ('7', '924'), ('7', '925'), ('7', '926'), ('7', '927'), ('7', '928'), ('7', '929'), ('7', '930'), ('51', '931'), ('7', '932'), ('9', '933'), ('7', '934'), ('7', '935'), ('48', '936'), ('7', '937'), ('7', '938'), ('7', '939'), ('51', '940'), ('7', '941'), ('7', '942'), ('7', '943'), ('7', '944'), ('7', '945'), ('7', '946'), ('49', '947'), ('7', '948'), ('7', '949'), ('7', '951'), ('7', '952'), ('7', '953'), ('7', '954'), ('7', '955'), ('7', '956'), ('7', '957'), ('7', '958'), ('7', '959'), ('51', '960'), ('7', '961'), ('7', '962'), ('7', '963'), ('7', '964'), ('7', '966'), ('7', '967'), ('7', '969'), ('7', '970'), ('7', '971'), ('7', '972'), ('7', '973'), ('7', '974'), ('7', '975'), ('7', '976'), ('7', '977'), ('7', '978'), ('7', '979'), ('7', '980'), ('7', '981'), ('7', '982'), ('7', '983'), ('48', '984'), ('7', '985'), ('7', '986'), ('7', '987'), ('7', '988'), ('7', '989'), ('48', '990'), ('7', '991'), ('49', '992'), ('7', '993'), ('7', '994'), ('7', '995'), ('7', '996'), ('9', '997'), ('7', '998'), ('7', '999'), ('7', '1000'), ('7', '1001'), ('7', '1002'), ('7', '1003'), ('7', '1004'), ('7', '1005'), ('7', '1006'), ('7', '1007'), ('7', '1008'), ('7', '1009'), ('7', '1010'), ('7', '1011'), ('7', '1012'), ('7', '1013'), ('7', '1014'), ('9', '1015'), ('7', '1016'), ('7', '1017'), ('7', '1018'), ('7', '1019'), ('7', '1020'), ('48', '1021'), ('7', '1022'), ('7', '1023'), ('7', '1024'), ('48', '1025'), ('7', '1027'), ('7', '1028'), ('7', '1029'), ('7', '1030'), ('7', '1031'), ('7', '1032'), ('7', '1033'), ('48', '1034'), ('7', '1035'), ('7', '1036'), ('7', '1037'), ('7', '1038'), ('7', '1039'), ('7', '1040'), ('7', '1041'), ('7', '1042'), ('7', '1043'), ('7', '1044'), ('7', '1045'), ('7', '1046'), ('7', '1047'), ('7', '1048'), ('7', '1049'), ('7', '1050'), ('7', '1051'), ('7', '1052'), ('7', '1053'), ('7', '1055'), ('7', '1056'), ('7', '1057'), ('7', '1058'), ('7', '1059'), ('7', '1060'), ('7', '1061'), ('7', '1062'), ('7', '1063'), ('7', '1064'), ('7', '1065'), ('7', '1066'), ('7', '1067'), ('7', '1068'), ('51', '1069'), ('48', '1070'), ('7', '1071'), ('48', '1072'), ('48', '1073'), ('7', '1074'), ('7', '1075'), ('7', '1076'), ('7', '1078'), ('7', '1079'), ('7', '1080'), ('7', '1081'), ('7', '1082'), ('7', '1083'), ('7', '1084'), ('7', '1085'), ('7', '1086'), ('48', '1087'), ('7', '1088'), ('7', '1089'), ('7', '1090'), ('7', '1091'), ('7', '1092'), ('7', '1093'), ('7', '1094'), ('7', '1095'), ('7', '1096'), ('7', '1097'), ('7', '1098'), ('7', '1099'), ('7', '1100'), ('7', '1102'), ('49', '1103'), ('7', '1104'), ('7', '1105'), ('7', '1107'), ('7', '1109'), ('7', '1111'), ('7', '1112'), ('7', '1113'), ('7', '1114'), ('7', '1115'), ('7', '1116'), ('7', '1117'), ('7', '1118'), ('7', '1119'), ('7', '1120'), ('7', '1121'), ('7', '1122'), ('7', '1123'), ('7', '1124'), ('7', '1125'), ('7', '1126'), ('7', '1127'), ('7', '1128'), ('7', '1129'), ('7', '1130'), ('48', '1131'), ('7', '1132'), ('7', '1134'), ('7', '1135'), ('7', '1136'), ('7', '1137'), ('7', '1138'), ('7', '1139'), ('7', '1141'), ('7', '1142'), ('7', '1143'), ('7', '1144'), ('7', '1145'), ('7', '1146'), ('7', '1147'), ('7', '1148'), ('7', '1149'), ('7', '1150'), ('7', '1151'), ('7', '1152'), ('7', '1153'), ('7', '1154'), ('7', '1155'), ('49', '1156'), ('7', '1157'), ('7', '1158'), ('7', '1159'), ('7', '1160'), ('9', '1161'), ('7', '1162'), ('7', '1163'), ('7', '1164'), ('7', '1165'), ('7', '1166'), ('7', '1167'), ('7', '1168'), ('7', '1169'), ('7', '1170'), ('7', '1171'), ('7', '1172'), ('7', '1173'), ('7', '1174'), ('7', '1175'), ('7', '1176'), ('7', '1177'), ('7', '1178'), ('7', '1179'), ('7', '1180'), ('7', '1181'), ('7', '1183'), ('7', '1184'), ('7', '1185'), ('7', '1186'), ('7', '1187'), ('7', '1189'), ('7', '1190'), ('7', '1191'), ('7', '1192'), ('7', '1193'), ('7', '1194'), ('7', '1195'), ('7', '1196'), ('7', '1197'), ('7', '1198'), ('7', '1199'), ('7', '1200'), ('7', '1201'), ('7', '1202'), ('7', '1203'), ('7', '1204'), ('7', '1205'), ('7', '1206'), ('7', '1207'), ('7', '1208'), ('49', '1209'), ('7', '1210'), ('7', '1211'), ('7', '1212'), ('7', '1213'), ('9', '1214'), ('7', '1215'), ('7', '1216'), ('7', '1217'), ('7', '1218'), ('7', '1219'), ('7', '1220'), ('7', '1222'), ('7', '1223'), ('7', '1224'), ('7', '1225'), ('7', '1226'), ('7', '1227'), ('7', '1228'), ('7', '1229'), ('7', '1230'), ('7', '1231'), ('7', '1232'), ('7', '1233'), ('7', '1234'), ('7', '1236'), ('7', '1237'), ('7', '1238'), ('7', '1239'), ('7', '1240'), ('7', '1241'), ('7', '1242'), ('51', '1243'), ('7', '1244'), ('9', '1245'), ('7', '1246'), ('7', '1247'), ('7', '1248'), ('7', '1249'), ('7', '1250'), ('7', '1251'), ('7', '1252'), ('7', '1253'), ('7', '1254'), ('7', '1255'), ('7', '1256'), ('7', '1257'), ('7', '1258'), ('7', '1259'), ('7', '1260'), ('7', '1261'), ('7', '1262'), ('7', '1263'), ('7', '1264'), ('7', '1265'), ('7', '1266'), ('7', '1267'), ('7', '1268'), ('48', '1269'), ('7', '1270'), ('7', '1271'), ('7', '1272'), ('7', '1273'), ('7', '1274'), ('7', '1275'), ('48', '1276'), ('7', '1277'), ('7', '1278'), ('7', '1279'), ('48', '1280'), ('7', '1281'), ('48', '1282'), ('7', '1283'), ('7', '1284'), ('7', '1285'), ('7', '1286'), ('7', '1287'), ('49', '1288'), ('7', '1289'), ('7', '1290'), ('7', '1291'), ('7', '1292'), ('49', '1293'), ('7', '1295'), ('7', '1296'), ('7', '1297'), ('7', '1298'), ('7', '1299'), ('7', '1300'), ('7', '1302'), ('7', '1303'), ('7', '1305'), ('7', '1306'), ('7', '1307'), ('7', '1308'), ('51', '1309'), ('7', '1310'), ('7', '1311'), ('7', '1312'), ('7', '1313'), ('7', '1314'), ('7', '1315'), ('7', '1316'), ('7', '1317'), ('7', '1318'), ('7', '1319'), ('7', '1320'), ('7', '1321'), ('7', '1322'), ('7', '1323'), ('7', '1324'), ('7', '1325'), ('7', '1327'), ('7', '1328'), ('7', '1329'), ('7', '1330'), ('7', '1331'), ('7', '1332'), ('7', '1334'), ('49', '1335'), ('7', '1336'), ('7', '1337'), ('7', '1338'), ('48', '1339'), ('7', '1340'), ('7', '1341'), ('7', '1342'), ('7', '1343'), ('7', '1344'), ('7', '1345'), ('7', '1346'), ('7', '1347'), ('7', '1348'), ('7', '1349'), ('7', '1350'), ('7', '1351'), ('7', '1352'), ('7', '1353'), ('7', '1354'), ('7', '1355'), ('7', '1356'), ('7', '1357'), ('7', '1358'), ('7', '1359'), ('7', '1360'), ('7', '1361'), ('7', '1362'), ('7', '1364'), ('48', '1365'), ('50', '1366'), ('7', '1367'), ('7', '1368'), ('7', '1369'), ('7', '1370'), ('48', '1371'), ('48', '1372'), ('7', '1373'), ('7', '1375'), ('7', '1376'), ('7', '1377'), ('7', '1378'), ('49', '1379'), ('7', '1380'), ('7', '1381'), ('7', '1382'), ('7', '1383'), ('7', '1384'), ('7', '1385'), ('7', '1387'), ('7', '1388'), ('48', '1389'), ('7', '1390'), ('7', '1391'), ('7', '1392'), ('7', '1393'), ('7', '1394'), ('7', '1395'), ('7', '1396'), ('7', '1397'), ('7', '1398'), ('48', '1399'), ('7', '1400'), ('7', '1401'), ('7', '1403'), ('7', '1404'), ('7', '1405'), ('7', '1406'), ('7', '1407'), ('7', '1408'), ('7', '1409'), ('7', '1410'), ('9', '1411'), ('7', '1412'), ('7', '1413'), ('7', '1414'), ('7', '1415'), ('7', '1416'), ('7', '1417'), ('9', '1418'), ('7', '1419'), ('7', '1420'), ('50', '1421'), ('7', '1422'), ('7', '1423'), ('7', '1424'), ('7', '1426'), ('7', '1427'), ('7', '1428'), ('7', '1429'), ('7', '1430'), ('7', '1433'), ('7', '1434'), ('7', '1435'), ('7', '1436'), ('7', '1437'), ('7', '1438'), ('7', '1439'), ('7', '1440'), ('7', '1441'), ('7', '1442'), ('7', '1443'), ('50', '1444'), ('7', '1445'), ('7', '1446'), ('7', '1447'), ('7', '1448'), ('7', '1449'), ('7', '1450'), ('7', '1451'), ('7', '1452'), ('7', '1453'), ('7', '1454'), ('7', '1455'), ('7', '1456'), ('49', '1457'), ('7', '1458'), ('7', '1459'), ('7', '1460'), ('7', '1461'), ('7', '1462'), ('7', '1463'), ('50', '1464'), ('7', '1465'), ('7', '1466'), ('7', '1467'), ('7', '1468'), ('7', '1469'), ('49', '1470'), ('7', '1472'), ('7', '1473'), ('7', '1474'), ('7', '1475'), ('7', '1476'), ('7', '1477'), ('7', '1478'), ('7', '1479'), ('7', '1480'), ('7', '1481'), ('7', '1482'), ('7', '1483'), ('7', '1484'), ('7', '1485'), ('7', '1486'), ('7', '1487'), ('7', '1488'), ('7', '1489'), ('7', '1490'), ('48', '1491'), ('7', '1492'), ('7', '1493'), ('7', '1494'), ('7', '1495'), ('7', '1496'), ('7', '1497'), ('7', '1498'), ('7', '1499'), ('49', '1500'), ('7', '1501'), ('7', '1502'), ('7', '1503'), ('7', '1504'), ('7', '1505'), ('7', '1506'), ('7', '1507'), ('7', '1508'), ('7', '1510'), ('7', '1511'), ('7', '1512'), ('7', '1513'), ('7', '1514'), ('7', '1515'), ('7', '1516'), ('7', '1517'), ('7', '1518'), ('7', '1519'), ('7', '1520'), ('7', '1521'), ('7', '1522'), ('7', '1523'), ('7', '1524'), ('7', '1525'), ('7', '1526'), ('7', '1527'), ('7', '1528'), ('7', '1529'), ('7', '1530'), ('7', '1531'), ('7', '1532'), ('7', '1533'), ('7', '1534'), ('7', '1535'), ('48', '1536'), ('7', '1537'), ('7', '1538'), ('7', '1539'), ('48', '1540'), ('7', '1541'), ('7', '1542'), ('7', '1543'), ('7', '1544'), ('7', '1545'), ('7', '1546'), ('7', '1547'), ('7', '1549'), ('7', '1550'), ('7', '1551'), ('48', '1552'), ('7', '1553'), ('48', '1554'), ('7', '1556'), ('7', '1557'), ('48', '1558'), ('7', '1559'), ('7', '1560'), ('7', '1561'), ('7', '1562'), ('7', '1563'), ('7', '1564'), ('7', '1566'), ('7', '1567'), ('7', '1568'), ('7', '1569'), ('7', '1570'), ('7', '1571'), ('7', '1572'), ('7', '1573'), ('7', '1574'), ('7', '1575'), ('7', '1576'), ('7', '1577'), ('7', '1578'), ('7', '1579'), ('7', '1580'), ('7', '1581'), ('7', '1582'), ('7', '1583'), ('7', '1584'), ('7', '1585'), ('7', '1586'), ('7', '1587'), ('48', '1588'), ('7', '1589'), ('7', '1590'), ('7', '1591'), ('49', '1592'), ('48', '1593'), ('7', '1594'), ('7', '1595'), ('7', '1597'), ('7', '1598'), ('7', '1599'), ('7', '1600'), ('7', '1601'), ('7', '1602'), ('7', '1603'), ('7', '1604'), ('7', '1605'), ('7', '1609'), ('7', '1610'), ('7', '1611'), ('7', '1612'), ('7', '1613'), ('7', '1614'), ('48', '1616'), ('7', '1617'), ('7', '1618'), ('7', '1619'), ('7', '1620'), ('7', '1621'), ('7', '1622'), ('7', '1623'), ('7', '1624'), ('7', '1625'), ('7', '1626'), ('7', '1627'), ('48', '1628'), ('7', '1629'), ('7', '1630'), ('7', '1631'), ('7', '1632'), ('7', '1633'), ('7', '1634'), ('49', '1635'), ('7', '1636'), ('7', '1637'), ('7', '1638'), ('7', '1639'), ('7', '1640'), ('7', '1641'), ('7', '1642'), ('7', '1644'), ('7', '1645'), ('7', '1646'), ('7', '1648'), ('9', '1649'), ('7', '1650'), ('7', '1651'), ('7', '1652'), ('7', '1653'), ('7', '1654'), ('7', '1655'), ('7', '1656'), ('7', '1657'), ('7', '1658'), ('7', '1659'), ('7', '1660'), ('7', '1662'), ('7', '1663'), ('7', '1664'), ('7', '1665'), ('7', '1666'), ('7', '1667'), ('7', '1668'), ('7', '1669'), ('7', '1670'), ('9', '1672'), ('7', '1673'), ('7', '1674'), ('7', '1675'), ('9', '1676'), ('7', '1677'), ('7', '1678'), ('7', '1679'), ('7', '1680'), ('7', '1681'), ('7', '1682'), ('48', '1683'), ('7', '1684'), ('7', '1686'), ('7', '1687'), ('48', '1688'), ('7', '1689'), ('7', '1690'), ('49', '1691'), ('7', '1692'), ('7', '1693'), ('7', '1694'), ('7', '1695'), ('7', '1696'), ('7', '1697'), ('7', '1698'), ('7', '1699'), ('7', '1700'), ('7', '1701'), ('7', '1702'), ('7', '1703'), ('7', '1704'), ('7', '1705'), ('7', '1706'), ('7', '1707'), ('7', '1708'), ('7', '1709'), ('7', '1710'), ('7', '1712'), ('7', '1713'), ('7', '1714'), ('7', '1715'), ('7', '1716'), ('7', '1718'), ('7', '1719'), ('48', '1720'), ('7', '1721'), ('7', '1722'), ('7', '1723'), ('48', '1724'), ('7', '1725'), ('7', '1726'), ('7', '1727'), ('7', '1728'), ('7', '1729'), ('7', '1730'), ('7', '1731'), ('7', '1732'), ('7', '1733'), ('7', '1734'), ('7', '1735'), ('7', '1736'), ('9', '1737'), ('7', '1738'), ('7', '1739'), ('48', '1740'), ('48', '1741'), ('7', '1742'), ('7', '1743'), ('7', '1744'), ('7', '1745'), ('7', '1746'), ('7', '1747'), ('7', '1748'), ('7', '1749'), ('7', '1750'), ('7', '1751'), ('7', '1752'), ('7', '1753'), ('7', '1755'), ('48', '1756'), ('7', '1757'), ('49', '1758'), ('7', '1759'), ('7', '1760'), ('7', '1762'), ('7', '1763'), ('7', '1764'), ('7', '1765'), ('7', '1766'), ('7', '1767'), ('7', '1768'), ('7', '1769'), ('7', '1770'), ('7', '1771'), ('7', '1772'), ('7', '1773'), ('7', '1774'), ('7', '1775'), ('7', '1776'), ('7', '1777'), ('7', '1778'), ('7', '1779'), ('48', '1780'), ('7', '1781'), ('7', '1782'), ('7', '1783'), ('7', '1784'), ('7', '1785'), ('7', '1786'), ('7', '1787'), ('7', '1788'), ('7', '1789'), ('7', '1791'), ('7', '1792'), ('7', '1793'), ('7', '1794'), ('48', '1795'), ('7', '1796'), ('7', '1797'), ('7', '1798'), ('7', '1799'), ('7', '1801'), ('7', '1803'), ('7', '1805'), ('7', '1806'), ('7', '1807'), ('7', '1809'), ('7', '1810'), ('7', '1811'), ('7', '1812'), ('48', '1813'), ('7', '1814'), ('7', '1815'), ('7', '1816'), ('7', '1817'), ('7', '1818'), ('7', '1819'), ('7', '1820'), ('7', '1821'), ('7', '1822'), ('7', '1823'), ('7', '1824'), ('7', '1825'), ('7', '1826'), ('7', '1827'), ('7', '1828'), ('7', '1829'), ('7', '1830'), ('7', '1831'), ('7', '1832'), ('7', '1833'), ('7', '1834'), ('7', '1835'), ('7', '1837'), ('7', '1838'), ('7', '1839'), ('7', '1840'), ('7', '1841'), ('7', '1842'), ('7', '1843'), ('7', '1844'), ('7', '1845'), ('7', '1846'), ('7', '1847'), ('7', '1848'), ('7', '1849'), ('7', '1850'), ('7', '1851'), ('7', '1852'), ('7', '1853'), ('48', '1854'), ('7', '1855'), ('7', '1856'), ('7', '1857'), ('7', '1858'), ('7', '1859'), ('7', '1860'), ('7', '1861'), ('7', '1862'), ('7', '1863'), ('7', '1864'), ('7', '1865'), ('7', '1866'), ('7', '1867'), ('7', '1868'), ('7', '1869'), ('7', '1870'), ('7', '1873'), ('7', '1874'), ('7', '1875'), ('7', '1876'), ('7', '1877'), ('7', '1878'), ('7', '1879'), ('7', '1880'), ('7', '1881'), ('7', '1882'), ('7', '1883'), ('7', '1884'), ('7', '1885'), ('7', '1886'), ('7', '1887'), ('7', '1888'), ('7', '1889'), ('7', '1890'), ('7', '1891'), ('7', '1892'), ('7', '1895'), ('7', '1896'), ('7', '1897'), ('7', '1898'), ('7', '1900'), ('9', '1901'), ('7', '1902'), ('7', '1903'), ('7', '1904'), ('7', '1905'), ('7', '1906'), ('7', '1907'), ('9', '1908'), ('7', '1909'), ('7', '1910'), ('7', '1911'), ('7', '1912'), ('7', '1913'), ('48', '1914'), ('7', '1915'), ('7', '1916'), ('7', '1917'), ('7', '1918'), ('7', '1919'), ('7', '1920'), ('7', '1922'), ('48', '1923'), ('7', '1925'), ('7', '1926'), ('7', '1927'), ('7', '1928'), ('7', '1929'), ('7', '1930'), ('7', '1931'), ('7', '1932'), ('48', '1933'), ('7', '1935'), ('7', '1937'), ('7', '1938'), ('7', '1939'), ('7', '1940'), ('7', '1941'), ('7', '1942'), ('7', '1943'), ('48', '1944'), ('7', '1945'), ('7', '1946'), ('7', '1947'), ('7', '1948'), ('7', '1949'), ('7', '1950'), ('7', '1951'), ('7', '1952'), ('7', '1953'), ('7', '1954'), ('7', '1955'), ('7', '1956'), ('7', '1957'), ('7', '1958'), ('7', '1959'), ('7', '1960'), ('7', '1961'), ('7', '1962'), ('7', '1963'), ('7', '1964'), ('7', '1966'), ('7', '1967'), ('7', '1968'), ('7', '1969'), ('48', '1970'), ('7', '1971'), ('7', '1972'), ('7', '1973'), ('7', '1975'), ('7', '1976'), ('7', '1977'), ('7', '1978'), ('7', '1979'), ('7', '1980'), ('7', '1981'), ('7', '1982'), ('7', '1983'), ('7', '1984'), ('7', '1985'), ('7', '1986'), ('48', '1987'), ('7', '1988'), ('7', '1989'), ('7', '1992'), ('7', '1993'), ('7', '1994'), ('7', '1995'), ('7', '1996'), ('48', '1997'), ('7', '1998'), ('7', '2000'), ('7', '2001'), ('7', '2002'), ('7', '2003'), ('7', '2004'), ('7', '2005'), ('7', '2006'), ('7', '2007'), ('7', '2009'), ('7', '2011'), ('7', '2012'), ('7', '2014'), ('7', '2015'), ('7', '2016'), ('7', '2017'), ('7', '2018'), ('7', '2019'), ('7', '2020'), ('7', '2021'), ('7', '2022'), ('7', '2023'), ('7', '2024'), ('7', '2025'), ('7', '2026'), ('7', '2027'), ('7', '2028'), ('7', '2029'), ('7', '2030'), ('7', '2031'), ('7', '2032'), ('48', '2033'), ('7', '2034'), ('7', '2035'), ('7', '2036'), ('7', '2037'), ('7', '2038'), ('7', '2039'), ('7', '2040'), ('7', '2041'), ('7', '2042'), ('7', '2043'), ('7', '2044'), ('7', '2045'), ('7', '2046'), ('7', '2047'), ('7', '2048'), ('48', '2049'), ('7', '2050'), ('7', '2051'), ('7', '2052'), ('7', '2053'), ('7', '2054'), ('7', '2055'), ('7', '2056'), ('7', '2057'), ('7', '2058'), ('7', '2059'), ('48', '2060'), ('7', '2061'), ('7', '2062'), ('7', '2063'), ('7', '2064'), ('7', '2065'), ('7', '2066'), ('7', '2067'), ('7', '2068'), ('7', '2069'), ('7', '2070'), ('7', '2071'), ('7', '2072'), ('7', '2073'), ('7', '2074'), ('7', '2075'), ('7', '2076'), ('7', '2077'), ('7', '2078'), ('49', '2080'), ('7', '2081'), ('7', '2082'), ('7', '2083'), ('7', '2084'), ('7', '2085'), ('7', '2086'), ('7', '2087'), ('7', '2088'), ('7', '2089'), ('7', '2090'), ('7', '2091'), ('7', '2092'), ('7', '2093'), ('48', '2094'), ('7', '2095'), ('7', '2096'), ('7', '2097'), ('7', '2098'), ('7', '2099'), ('7', '2100'), ('7', '2101'), ('7', '2102'), ('7', '2103'), ('7', '2104'), ('7', '2105'), ('7', '2107'), ('48', '2108'), ('7', '2109'), ('7', '2110'), ('9', '2111'), ('7', '2112'), ('7', '2113'), ('7', '2114'), ('7', '2115'), ('7', '2116'), ('7', '2117'), ('7', '2119'), ('7', '2120'), ('7', '2121'), ('7', '2122'), ('7', '2123'), ('7', '2124'), ('7', '2125'), ('7', '2126'), ('49', '2127'), ('7', '2128'), ('7', '2129'), ('7', '2130'), ('7', '2131'), ('7', '2132'), ('7', '2133'), ('7', '2134'), ('7', '2135'), ('7', '2136'), ('7', '2137'), ('7', '2138'), ('7', '2139'), ('7', '2140'), ('7', '2141'), ('7', '2142'), ('7', '2143'), ('7', '2144'), ('7', '2145'), ('7', '2146'), ('7', '2147'), ('7', '2149'), ('7', '2150'), ('7', '2151'), ('7', '2152'), ('7', '2153'), ('7', '2154'), ('7', '2155'), ('7', '2156'), ('7', '2158'), ('51', '2159'), ('7', '2160'), ('7', '2161'), ('7', '2162'), ('7', '2163'), ('7', '2164'), ('7', '2165'), ('7', '2166'), ('7', '2167'), ('7', '2168'), ('7', '2169'), ('7', '2170'), ('7', '2171'), ('7', '2172'), ('7', '2173'), ('7', '2174'), ('7', '2175'), ('7', '2176'), ('7', '2177'), ('7', '2178'), ('7', '2179'), ('7', '2180'), ('48', '2181'), ('7', '2183'), ('7', '2184'), ('7', '2185'), ('7', '2186'), ('7', '2187'), ('7', '2188'), ('7', '2189'), ('7', '2190'), ('7', '2191'), ('7', '2192'), ('7', '2193'), ('7', '2194'), ('9', '2195'), ('7', '2196'), ('7', '2197'), ('7', '2198'), ('7', '2199'), ('7', '2200'), ('7', '2201'), ('7', '2203'), ('7', '2204'), ('7', '2206'), ('7', '2207'), ('7', '2208'), ('7', '2209'), ('7', '2210'), ('7', '2211'), ('7', '2212'), ('7', '2213'), ('7', '2214'), ('7', '2215'), ('7', '2216'), ('7', '2217'), ('7', '2218'), ('7', '2219'), ('7', '2220'), ('7', '2221'), ('7', '2222'), ('7', '2224'), ('7', '2225'), ('7', '2226'), ('9', '2227'), ('7', '2228'), ('7', '2229'), ('7', '2230'), ('7', '2231'), ('7', '2232'), ('7', '2233'), ('7', '2234'), ('7', '2235'), ('7', '2236'), ('7', '2237'), ('7', '2238'), ('7', '2239'), ('7', '2240'), ('7', '2241'), ('7', '2242'), ('7', '2243'), ('7', '2244'), ('7', '2246'), ('7', '2247'), ('7', '2248'), ('7', '2249'), ('7', '2250'), ('7', '2251'), ('7', '2252'), ('7', '2253'), ('7', '2254'), ('7', '2255'), ('7', '2256'), ('7', '2257'), ('7', '2258'), ('7', '2259'), ('7', '2260'), ('7', '2261'), ('7', '2262'), ('7', '2263'), ('7', '2264'), ('7', '2265'), ('49', '2266'), ('7', '2267'), ('7', '2268'), ('7', '2269'), ('7', '2270'), ('7', '2271'), ('7', '2272'), ('7', '2273'), ('7', '2274'), ('7', '2275'), ('7', '2276'), ('7', '2277'), ('7', '2278'), ('7', '2279'), ('7', '2280'), ('7', '2281'), ('7', '2282'), ('7', '2283'), ('7', '2284'), ('7', '2285'), ('7', '2286'), ('7', '2287'), ('7', '2288'), ('7', '2289'), ('7', '2290'), ('7', '2291'), ('7', '2292'), ('7', '2293'), ('7', '2294'), ('7', '2295'), ('7', '2296'), ('7', '2297'), ('7', '2298'), ('7', '2299'), ('7', '2300'), ('7', '2301'), ('9', '2302'), ('7', '2303'), ('7', '2304'), ('7', '2305'), ('7', '2306'), ('7', '2307'), ('7', '2308'), ('7', '2309'), ('7', '2310'), ('7', '2311'), ('7', '2312'), ('7', '2313'), ('7', '2314'), ('7', '2315'), ('7', '2316'), ('7', '2317'), ('7', '2318'), ('7', '2319'), ('7', '2320'), ('7', '2321'), ('7', '2322'), ('7', '2323'), ('7', '2324'), ('7', '2325'), ('7', '2326'), ('7', '2327'), ('7', '2328'), ('7', '2329'), ('7', '2330'), ('7', '2331'), ('48', '2332'), ('7', '2333'), ('7', '2334'), ('7', '2335'), ('7', '2336'), ('7', '2337'), ('7', '2338'), ('7', '2339'), ('7', '2340'), ('7', '2341'), ('7', '2342'), ('7', '2343'), ('7', '2344'), ('7', '2345'), ('7', '2346'), ('7', '2347'), ('7', '2348'), ('7', '2349'), ('7', '2350'), ('7', '2351'), ('7', '2352'), ('7', '2353'), ('48', '2354'), ('48', '2355'), ('49', '2356'), ('9', '2358'), ('7', '2360'), ('48', '2362'), ('48', '2364'), ('7', '2366'), ('48', '2367'), ('7', '2368'), ('7', '2370'), ('7', '2371'), ('7', '2372'), ('7', '2374'), ('9', '2380'), ('9', '2381'), ('9', '2382'), ('9', '2383'), ('7', '2385'), ('7', '2386'), ('7', '2387'), ('7', '2388'), ('7', '2389'), ('7', '2390'), ('7', '2391'), ('7', '2392'), ('7', '2393'), ('7', '2394'), ('7', '2395'), ('7', '2396'), ('7', '2397'), ('7', '2398'), ('7', '2399'), ('7', '2400'), ('7', '2401'), ('7', '2402'), ('7', '2403'), ('7', '2404'), ('7', '2405'), ('7', '2406'), ('7', '2407'), ('7', '2408'), ('7', '2409'), ('7', '2410'), ('7', '2411'), ('7', '2412'), ('7', '2413'), ('7', '2414'), ('7', '2415'), ('7', '2416'), ('7', '2417'), ('7', '2418'), ('7', '2419'), ('7', '2420'), ('7', '2421'), ('7', '2422'), ('7', '2423'), ('7', '2424'), ('7', '2425'), ('7', '2426'), ('7', '2427'), ('7', '2428'), ('7', '2429'), ('7', '2430'), ('7', '2431'), ('7', '2432'), ('7', '2433'), ('7', '2434'), ('7', '2435'), ('7', '2436'), ('7', '2437'), ('7', '2438'), ('7', '2439'), ('7', '2440'), ('7', '2441'), ('7', '2442'), ('7', '2443'), ('7', '2444'), ('7', '2445'), ('7', '2446'), ('7', '2447'), ('7', '2449'), ('7', '2450'), ('7', '2451'), ('7', '2452'), ('7', '2453'), ('7', '2454'), ('7', '2455'), ('7', '2456'), ('7', '2457'), ('7', '2458'), ('7', '2459'), ('7', '2460'), ('7', '2461'), ('7', '2462'), ('7', '2463'), ('7', '2464'), ('7', '2465'), ('7', '2466'), ('7', '2467'), ('7', '2468'), ('7', '2469'), ('7', '2470'), ('7', '2471'), ('7', '2472'), ('7', '2473'), ('7', '2474'), ('7', '2475'), ('7', '2476'), ('7', '2477'), ('7', '2478'), ('7', '2479'), ('7', '2480'), ('7', '2481'), ('7', '2482'), ('7', '2483'), ('7', '2484'), ('7', '2485'), ('7', '2486'), ('7', '2487'), ('7', '2488'), ('7', '2489'), ('7', '2490'), ('7', '2491'), ('7', '2492'), ('7', '2493'), ('7', '2494'), ('7', '2495'), ('7', '2496'), ('7', '2497'), ('7', '2498'), ('7', '2499'), ('7', '2500'), ('7', '2501'), ('7', '2502'), ('7', '2504'), ('7', '2505'), ('7', '2506'), ('7', '2507'), ('7', '2508'), ('7', '2510'), ('7', '2511'), ('7', '2512'), ('7', '2513'), ('7', '2514'), ('7', '2515'), ('7', '2516'), ('7', '2517'), ('7', '2518'), ('7', '2519'), ('7', '2520'), ('7', '2521'), ('7', '2522'), ('7', '2523'), ('7', '2524'), ('7', '2525'), ('7', '2526'), ('7', '2527'), ('7', '2528'), ('7', '2529'), ('7', '2530'), ('7', '2531'), ('7', '2532'), ('7', '2533'), ('7', '2534'), ('7', '2535'), ('7', '2536'), ('7', '2537'), ('7', '2538'), ('7', '2539'), ('7', '2540'), ('7', '2541'), ('7', '2542'), ('7', '2543'), ('7', '2544'), ('7', '2545'), ('7', '2546'), ('7', '2547'), ('7', '2548'), ('7', '2549'), ('7', '2550'), ('7', '2551'), ('7', '2552'), ('7', '2553'), ('7', '2554'), ('7', '2555'), ('7', '2556'), ('7', '2557'), ('7', '2558'), ('7', '2559'), ('7', '2560'), ('7', '2562'), ('7', '2563'), ('7', '2564'), ('7', '2565'), ('7', '2566'), ('7', '2567'), ('7', '2568'), ('7', '2569'), ('7', '2570'), ('7', '2571'), ('7', '2572'), ('7', '2573'), ('7', '2574'), ('7', '2575'), ('7', '2576'), ('7', '2577'), ('7', '2578'), ('7', '2579'), ('7', '2580'), ('7', '2581'), ('7', '2582'), ('7', '2583'), ('7', '2584'), ('7', '2585'), ('7', '2586'), ('7', '2587'), ('7', '2588'), ('7', '2589'), ('7', '2590'), ('7', '2591'), ('7', '2592'), ('7', '2593'), ('7', '2594'), ('7', '2595'), ('7', '2596'), ('7', '2597'), ('7', '2598'), ('7', '2599'), ('7', '2600'), ('7', '2601'), ('7', '2602'), ('7', '2603'), ('7', '2604'), ('7', '2605'), ('7', '2606'), ('7', '2607'), ('7', '2608'), ('7', '2609'), ('7', '2610'), ('7', '2611'), ('7', '2612'), ('7', '2613'), ('7', '2614'), ('7', '2615'), ('7', '2616'), ('7', '2617'), ('7', '2618'), ('7', '2619'), ('7', '2620'), ('7', '2621'), ('7', '2622'), ('7', '2623'), ('7', '2624'), ('7', '2625'), ('7', '2626'), ('7', '2627'), ('7', '2628'), ('7', '2629'), ('7', '2630'), ('7', '2631'), ('7', '2632'), ('7', '2633'), ('7', '2634'), ('7', '2635'), ('7', '2636'), ('7', '2637'), ('7', '2638'), ('7', '2639'), ('7', '2640'), ('7', '2641'), ('7', '2642'), ('7', '2643'), ('7', '2644'), ('7', '2645'), ('7', '2646'), ('7', '2647'), ('7', '2648'), ('7', '2649'), ('7', '2650'), ('7', '2651'), ('7', '2652'), ('7', '2653'), ('7', '2654'), ('7', '2655'), ('7', '2656'), ('7', '2657'), ('7', '2658'), ('7', '2659'), ('7', '2660'), ('7', '2661'), ('7', '2662'), ('7', '2663'), ('7', '2664'), ('7', '2665'), ('7', '2666'), ('7', '2667'), ('7', '2668'), ('7', '2669'), ('7', '2670'), ('7', '2671'), ('7', '2672'), ('7', '2673'), ('7', '2674'), ('7', '2675'), ('7', '2676'), ('7', '2677'), ('7', '2678'), ('7', '2679'), ('7', '2680'), ('7', '2681'), ('7', '2682'), ('7', '2683'), ('7', '2684'), ('7', '2685'), ('7', '2686'), ('7', '2687'), ('7', '2689'), ('7', '2690'), ('7', '2692'), ('7', '2693'), ('7', '2694'), ('7', '2695'), ('7', '2696'), ('7', '2697'), ('7', '2698'), ('7', '2699'), ('7', '2700'), ('7', '2701'), ('7', '2702'), ('7', '2704'), ('7', '2705'), ('7', '2706'), ('7', '2707'), ('7', '2708'), ('7', '2709'), ('7', '2710'), ('7', '2711'), ('7', '2712'), ('7', '2713'), ('7', '2714'), ('7', '2715'), ('7', '2716'), ('7', '2717'), ('7', '2718'), ('7', '2719'), ('7', '2720'), ('7', '2721'), ('7', '2722'), ('7', '2723'), ('7', '2724'), ('7', '2726'), ('7', '2727'), ('7', '2729'), ('7', '2730'), ('7', '2731'), ('7', '2732'), ('7', '2733'), ('7', '2734'), ('7', '2735'), ('7', '2736'), ('7', '2737'), ('7', '2738'), ('7', '2739'), ('7', '2740'), ('7', '2741'), ('7', '2742'), ('7', '2743'), ('7', '2744'), ('7', '2745'), ('7', '2747'), ('7', '2748'), ('7', '2749'), ('7', '2750'), ('7', '2751'), ('7', '2752'), ('7', '2753'), ('7', '2754'), ('7', '2755'), ('7', '2756'), ('7', '2757'), ('7', '2758'), ('7', '2759'), ('7', '2760'), ('7', '2761'), ('7', '2762'), ('7', '2763'), ('7', '2764'), ('7', '2765'), ('7', '2766'), ('7', '2767'), ('7', '2768'), ('7', '2769'), ('7', '2770'), ('7', '2771'), ('7', '2772'), ('7', '2773'), ('7', '2774'), ('7', '2775'), ('7', '2776'), ('2', '36'), ('2', '131'), ('2', '247'), ('2', '270'), ('2', '298'), ('2', '427'), ('2', '484'), ('2', '553'), ('2', '684'), ('2', '699'), ('2', '774'), ('2', '777'), ('2', '788'), ('2', '979'), ('2', '1036'), ('2', '1189'), ('2', '1281'), ('2', '1406'), ('2', '1411'), ('2', '1424'), ('2', '1514'), ('2', '1557'), ('2', '1558'), ('2', '2113'), ('2', '2155'), ('2', '2212'), ('2', '2360'), ('2', '2366'), ('2', '2534'), ('8', '1'), ('9', '2777'), ('7', '2778'), ('7', '2779'), ('7', '2780'), ('7', '2781'), ('7', '2782'), ('7', '2783'), ('7', '2784'), ('7', '2785'), ('7', '2786'), ('7', '2787'), ('7', '2788'), ('7', '2789'), ('7', '2790'), ('7', '2791'), ('7', '2792'), ('7', '2793'), ('7', '2794'), ('2', '2245'), ('9', '2245'), ('2', '734'), ('7', '734'), ('2', '2008'), ('7', '2008'), ('1', '13'), ('9', '13'), ('48', '1872'), ('48', '516'), ('48', '707'), ('48', '586'), ('48', '678'), ('49', '2509'), ('48', '4'), ('48', '1110'), ('48', '55'), ('48', '2728'), ('48', '7725'), ('2', '193'), ('7', '193'), ('7', '7751'), ('7', '7749'), ('7', '3'), ('9', '266'), ('9', '640'), ('9', '1608'), ('48', '1643'), ('2', '1606'), ('7', '1606'), ('7', '7724'), ('48', '2561'), ('7', '2363'), ('7', '7747'), ('7', '7757'), ('48', '649'), ('7', '1386'), ('7', '7758'), ('7', '7765'), ('7', '7766'), ('7', '7767'), ('7', '7768'), ('7', '7769'), ('7', '7770'), ('48', '1304'), ('48', '861'), ('7', '7745'), ('7', '7756'), ('7', '7746'), ('48', '419'), ('7', '7748'), ('7', '7771'), ('7', '7772'), ('48', '1182'), ('48', '1647'), ('7', '7778'), ('7', '7779'), ('7', '7732'), ('7', '7781'), ('7', '7782'), ('7', '7783'), ('7', '7784'), ('7', '7785'), ('7', '7786'), ('7', '7787'), ('7', '7788'), ('48', '1106'), ('48', '514'), ('7', '7789'), ('7', '7790'), ('7', '7763'), ('7', '7792'), ('7', '7793'), ('7', '7794'), ('7', '7795'), ('7', '7796'), ('7', '7797'), ('7', '7798'), ('7', '7799'), ('7', '7800'), ('7', '7801'), ('7', '7802'), ('7', '7803'), ('7', '7804'), ('7', '7805'), ('7', '7806'), ('7', '7807'), ('7', '7808'), ('7', '7809'), ('7', '7810'), ('7', '7811'), ('7', '7812'), ('7', '7813'), ('7', '7814'), ('7', '7815'), ('7', '7816'), ('7', '7817'), ('7', '7818'), ('7', '7819'), ('7', '7820'), ('7', '7821'), ('7', '7822'), ('7', '7823'), ('7', '7824'), ('7', '7825'), ('7', '7826'), ('7', '7827'), ('7', '7828'), ('7', '7829'), ('7', '7830'), ('7', '7831'), ('7', '7832'), ('7', '7833'), ('9', '567'), ('2', '7834'), ('7', '7834'), ('7', '7838'), ('7', '7839'), ('7', '7840'), ('7', '7841'), ('7', '7842'), ('7', '7843'), ('7', '7844'), ('7', '7845'), ('7', '7846'), ('7', '7847'), ('7', '7848'), ('7', '7849'), ('7', '7850'), ('7', '7851'), ('7', '7852'), ('7', '7853'), ('7', '7854'), ('7', '7855'), ('7', '7857'), ('7', '7858'), ('7', '7859'), ('7', '7860'), ('7', '7861'), ('7', '7862'), ('7', '7863'), ('7', '7864'), ('7', '7865'), ('7', '7867'), ('7', '7868'), ('7', '7869'), ('7', '7870'), ('7', '7871'), ('7', '7872'), ('7', '7873'), ('7', '7874'), ('7', '7875'), ('7', '7876'), ('7', '7877'), ('7', '7878'), ('7', '7879'), ('7', '7880'), ('7', '7881'), ('7', '7882'), ('47', '1188'), ('48', '1188'), ('7', '1965'), ('47', '1965'), ('47', '1363'), ('48', '1363'), ('9', '965'), ('47', '965'), ('7', '7884'), ('48', '7837'), ('49', '7835'), ('48', '7836'), ('7', '7866'), ('7', '7886'), ('7', '7887'), ('7', '7888'), ('7', '7889'), ('7', '7890'), ('7', '7891'), ('7', '7892'), ('7', '7893'), ('7', '7894'), ('7', '7895'), ('7', '7896'), ('7', '7897'), ('2', '7898'), ('7', '7898'), ('7', '7899'), ('2', '7856'), ('7', '7856'), ('7', '7900'), ('7', '7901'), ('7', '7902'), ('7', '7743'), ('7', '7903'), ('7', '7904'), ('48', '2205'), ('48', '1790'), ('7', '7907'), ('7', '7906'), ('7', '7905'), ('7', '7908'), ('7', '7909'), ('7', '7910'), ('7', '7911'), ('48', '7912'), ('7', '7913'), ('9', '7914'), ('48', '7915'), ('7', '7916'), ('48', '7917'), ('7', '7919'), ('49', '7920'), ('49', '7921'), ('7', '7922'), ('7', '7923'), ('48', '7924'), ('7', '7925'), ('7', '7926'), ('7', '7927'), ('7', '7928'), ('7', '7929'), ('7', '7930'), ('7', '7931'), ('7', '7932'), ('7', '7933'), ('7', '7934'), ('48', '7935'), ('7', '7936'), ('7', '7937'), ('48', '7938'), ('48', '1471'), ('7', '838'), ('48', '7939'), ('7', '7940'), ('48', '1711'), ('2', '1990'), ('48', '1990'), ('48', '811'), ('48', '14'), ('7', '2703'), ('7', '7941'), ('7', '7943'), ('7', '7944'), ('48', '7942'), ('7', '7947'), ('7', '7948'), ('7', '7949'), ('2', '7918'), ('7', '7918'), ('7', '7950'), ('7', '7951'), ('48', '7952'), ('7', '7762'), ('48', '1432'), ('7', '7953'), ('7', '7954'), ('7', '7955'), ('7', '7956'), ('7', '7957'), ('7', '7958'), ('7', '7959'), ('7', '7961'), ('7', '7962'), ('48', '452'), ('7', '7963'), ('7', '7964'), ('50', '1924'), ('7', '7885'), ('48', '791'), ('7', '7965'), ('7', '7966'), ('7', '7967'), ('7', '7968'), ('7', '7969'), ('48', '256'), ('7', '7970'), ('7', '7971'), ('7', '7972'), ('7', '7960'), ('7', '7973'), ('7', '7974'), ('7', '7764'), ('48', '2725'), ('50', '665'), ('7', '7975'), ('7', '7976'), ('7', '7977'), ('7', '7978'), ('7', '7979'), ('7', '7980'), ('48', '373'), ('48', '430'), ('7', '7982'), ('7', '7983'), ('7', '7984'), ('9', '397'), ('9', '805'), ('48', '1717'), ('48', '363'), ('7', '7986'), ('7', '7987'), ('7', '7988'), ('7', '7989'), ('7', '7990'), ('7', '7991'), ('7', '7992'), ('2', '968'), ('7', '968'), ('7', '7993'), ('7', '7994'), ('7', '7995'), ('7', '7997'), ('7', '7998'), ('7', '7999'), ('7', '8000'), ('7', '8001'), ('7', '8002'), ('7', '8003'), ('7', '8004'), ('7', '8005'), ('7', '8007'), ('2', '8006'), ('7', '8006'), ('7', '8008'), ('7', '8009'), ('7', '8010'), ('7', '8011'), ('7', '8012'), ('7', '8013'), ('7', '8014'), ('7', '8015'), ('49', '1565'), ('49', '2079'), ('7', '8016'), ('48', '1899'), ('48', '2746'), ('7', '8017'), ('7', '8018'), ('7', '8019'), ('7', '8020'), ('7', '8021'), ('7', '8022'), ('7', '7759'), ('7', '8025'), ('7', '8026'), ('7', '8027'), ('7', '8028'), ('7', '8024'), ('2', '121'), ('7', '121'), ('7', '8029'), ('9', '8030'), ('48', '2357'), ('7', '8031'), ('7', '8036'), ('7', '8035'), ('7', '8037'), ('7', '8038'), ('7', '8039'), ('7', '8040'), ('7', '8041'), ('7', '8042'), ('55', '1804'), ('55', '1509'), ('55', '1555'), ('55', '2384'), ('48', '2118'), ('7', '8044'), ('7', '8045'), ('7', '8046'), ('7', '8047'), ('7', '8048'), ('7', '8049'), ('7', '7741'), ('7', '8050'), ('7', '8051'), ('7', '8052'), ('7', '8053'), ('9', '1235'), ('56', '1235'), ('9', '1893'), ('56', '1893'), ('9', '2373'), ('56', '2373'), ('2', '288'), ('52', '288'), ('56', '288'), ('2', '1921'), ('52', '1921'), ('56', '1921'), ('2', '1133'), ('52', '1133'), ('56', '1133'), ('2', '1936'), ('52', '1936'), ('56', '1936'), ('2', '442'), ('52', '442'), ('56', '442'), ('2', '1615'), ('52', '1615'), ('56', '1615'), ('2', '1661'), ('52', '1661'), ('56', '1661'), ('2', '7981'), ('52', '7981'), ('56', '7981'), ('2', '1431'), ('52', '1431'), ('56', '1431'), ('2', '2365'), ('52', '2365'), ('56', '2365'), ('2', '2359'), ('52', '2359'), ('56', '2359'), ('2', '1294'), ('52', '1294'), ('56', '1294'), ('2', '2106'), ('52', '2106'), ('56', '2106'), ('2', '2361'), ('9', '2361'), ('56', '2361'), ('2', '1999'), ('52', '1999'), ('56', '1999'), ('7', '8054'), ('2', '62'), ('53', '62'), ('2', '192'), ('53', '192'), ('2', '374'), ('53', '374'), ('2', '574'), ('53', '574'), ('2', '664'), ('53', '664'), ('2', '871'), ('53', '871'), ('2', '950'), ('53', '950'), ('2', '1026'), ('53', '1026'), ('2', '1108'), ('53', '1108'), ('2', '1221'), ('53', '1221'), ('2', '1326'), ('53', '1326'), ('2', '1333'), ('53', '1333'), ('2', '1402'), ('53', '1402'), ('2', '1425'), ('53', '1425'), ('2', '1548'), ('53', '1548'), ('2', '1761'), ('53', '1761'), ('2', '1802'), ('53', '1802'), ('2', '1808'), ('53', '1808'), ('2', '1871'), ('53', '1871'), ('2', '1894'), ('53', '1894'), ('2', '1934'), ('53', '1934'), ('2', '1974'), ('53', '1974'), ('2', '1991'), ('53', '1991'), ('2', '2010'), ('53', '2010'), ('2', '2148'), ('53', '2148'), ('2', '2157'), ('53', '2157'), ('2', '2223'), ('53', '2223'), ('2', '7883'), ('53', '7883'), ('7', '8055'), ('7', '8056'), ('7', '8057'), ('7', '8058'), ('7', '8060'), ('7', '8061'), ('7', '8062'), ('7', '8063'), ('7', '8064'), ('2', '8065'), ('7', '8066'), ('7', '8032'), ('7', '8034'), ('7', '8068'), ('7', '8069'), ('7', '8070'), ('7', '8072'), ('7', '8073'), ('7', '8074'), ('7', '8075'), ('7', '8077'), ('7', '8078'), ('54', '921'), ('54', '1301'), ('54', '1800'), ('54', '133'), ('54', '295'), ('7', '8079'), ('7', '8080'), ('7', '8081'), ('7', '8082'), ('2', '2182'), ('56', '2182'), ('57', '2182'), ('7', '8083'), ('7', '8084'), ('7', '1836'), ('7', '8085'), ('9', '8086'), ('7', '8087'), ('7', '7985'), ('7', '8071'), ('7', '8088'), ('7', '8089'), ('7', '8090'), ('7', '8091'), ('7', '8092'), ('7', '8093'), ('7', '8094'), ('7', '8095'), ('7', '8096'), ('7', '8097'), ('7', '8098'), ('7', '8099'), ('7', '8076'), ('7', '8100'), ('7', '8101'), ('7', '8102'), ('7', '8103'), ('7', '8104'), ('48', '1077'), ('7', '8105'), ('7', '8106'), ('7', '8107'), ('7', '8108'), ('7', '8043'), ('7', '8109'), ('7', '8110'), ('7', '8111'), ('2', '1101'), ('53', '1101'), ('48', '8112'), ('7', '8113'), ('2', '1754'), ('53', '1754'), ('7', '8115'), ('48', '8059'), ('7', '7760'), ('7', '8116'), ('7', '8117'), ('7', '8118'), ('7', '8119'), ('7', '8120'), ('7', '8121'), ('48', '839'), ('7', '77'), ('7', '8122'), ('7', '8123'), ('7', '8124'), ('7', '8125'), ('7', '8126'), ('7', '8127'), ('7', '8128'), ('7', '8129'), ('7', '8130'), ('7', '8131'), ('7', '8132'), ('55', '8067'), ('7', '8133'), ('7', '8134'), ('7', '8135'), ('54', '1671'), ('7', '8136'), ('7', '8137'), ('7', '8138'), ('7', '8140'), ('9', '8141'), ('56', '8141'), ('7', '8142'), ('7', '8143'), ('2', '8114'), ('7', '8114'), ('55', '7996'), ('7', '8144'), ('7', '8145'), ('2', '1054'), ('53', '1054'), ('7', '8146'), ('7', '8147'), ('7', '8148'), ('7', '8149'), ('7', '8150'), ('7', '1374'), ('59', '1374'), ('7', '697'), ('59', '697'), ('7', '506'), ('59', '506'), ('48', '1140'), ('59', '1140'), ('7', '2691'), ('59', '2691'), ('7', '616'), ('59', '616'), ('7', '2688'), ('59', '2688'), ('7', '2202'), ('59', '2202'), ('2', '801'), ('7', '801'), ('59', '801'), ('7', '243'), ('59', '243'), ('7', '1685'), ('59', '1685'), ('48', '1607'), ('59', '1607'), ('49', '116'), ('59', '116'), ('7', '1596'), ('59', '1596'), ('7', '723'), ('59', '723'), ('2', '435'), ('53', '435'), ('59', '435'), ('7', '8151'), ('7', '8152'), ('9', '859'), ('56', '859'), ('59', '859'), ('59', '8141'), ('2', '703'), ('9', '703'), ('56', '703'), ('59', '703'), ('59', '2781'), ('59', '1'), ('59', '8141'), ('59', '16'), ('59', '2647'), ('59', '36'), ('59', '54'), ('59', '77'), ('59', '176'), ('59', '86'), ('59', '109'), ('59', '116'), ('59', '128'), ('59', '130'), ('59', '131'), ('59', '155'), ('59', '156'), ('59', '80'), ('59', '171'), ('59', '182'), ('59', '197'), ('59', '192'), ('59', '194'), ('59', '204'), ('59', '207'), ('59', '208'), ('59', '220'), ('59', '224'), ('59', '226'), ('59', '240'), ('59', '253'), ('59', '254'), ('59', '263'), ('59', '243'), ('59', '272'), ('59', '2356'), ('59', '2658'), ('59', '278'), ('59', '280'), ('59', '281'), ('59', '2357'), ('59', '339'), ('59', '379'), ('59', '386'), ('59', '2439'), ('59', '398'), ('59', '401'), ('59', '2106'), ('59', '423'), ('59', '435'), ('59', '449'), ('59', '1718'), ('59', '451'), ('59', '452'), ('59', '453'), ('59', '497'), ('59', '506'), ('59', '483'), ('59', '464'), ('59', '539'), ('59', '2473'), ('59', '473'), ('59', '2363'), ('59', '554'), ('59', '555'), ('59', '566'), ('59', '542'), ('59', '8059'), ('59', '603'), ('59', '839'), ('59', '831'), ('59', '855'), ('59', '611'), ('59', '616'), ('59', '621'), ('59', '2372'), ('59', '2361'), ('59', '2509'), ('59', '675'), ('59', '678'), ('59', '684'), ('59', '697'), ('59', '699'), ('59', '2502'), ('59', '703'), ('59', '859'), ('59', '861'), ('59', '871'), ('59', '2456'), ('59', '717'), ('59', '721'), ('59', '722'), ('59', '723'), ('59', '729'), ('59', '731'), ('59', '743'), ('59', '746'), ('59', '897'), ('59', '922'), ('59', '2367'), ('59', '931'), ('59', '968'), ('59', '938'), ('59', '947'), ('59', '2475'), ('59', '2688'), ('59', '960'), ('59', '747'), ('59', '755'), ('59', '782'), ('59', '791'), ('59', '801'), ('59', '984'), ('59', '1026'), ('59', '1025'), ('59', '2477'), ('59', '988'), ('59', '1001'), ('59', '990'), ('59', '1045'), ('59', '1053'), ('59', '8029'), ('59', '1072'), ('59', '1087'), ('59', '8046'), ('59', '1103'), ('59', '2485'), ('59', '1126'), ('59', '1131'), ('59', '1132'), ('59', '1140'), ('59', '1182'), ('59', '2470'), ('59', '1193'), ('59', '1235'), ('59', '1243'), ('59', '1242'), ('59', '2430'), ('59', '1232'), ('59', '1269'), ('59', '1280'), ('59', '1282'), ('59', '1309'), ('59', '2488'), ('59', '1351'), ('59', '1374'), ('59', '1389'), ('59', '1423'), ('59', '1437'), ('59', '2691'), ('59', '1461'), ('59', '1469'), ('59', '1468'), ('59', '1500'), ('59', '1514'), ('59', '1536'), ('59', '1565'), ('59', '1548'), ('59', '2454'), ('59', '1593'), ('59', '1595'), ('59', '1596'), ('59', '1602'), ('59', '1607'), ('59', '574'), ('59', '1569'), ('59', '1616'), ('59', '1622'), ('59', '1624'), ('59', '1647'), ('59', '1661'), ('59', '1691'), ('59', '1694'), ('59', '1720'), ('59', '1724'), ('59', '1740'), ('59', '1741'), ('59', '1780'), ('59', '1814'), ('59', '1815'), ('59', '2561'), ('59', '1836'), ('59', '1688'), ('59', '1685'), ('59', '1864'), ('59', '1924'), ('59', '1918'), ('59', '1923'), ('59', '1887'), ('59', '1893'), ('59', '1894'), ('59', '1896'), ('59', '66'), ('59', '68'), ('59', '71'), ('59', '2373'), ('59', '1974'), ('59', '1997'), ('59', '1991'), ('59', '2005'), ('59', '2032'), ('59', '2079'), ('59', '1933'), ('59', '2118'), ('59', '2157'), ('59', '2159'), ('59', '2182'), ('59', '2202'), ('59', '2210'), ('59', '2471'), ('59', '2250'), ('59', '2241'), ('7', '8153'), ('59', '8154'), ('59', '8154'), ('59', '8155'), ('59', '8156'), ('59', '8157'), ('59', '8158'), ('59', '8159'), ('59', '8160'), ('59', '8161'), ('59', '8162'), ('59', '8163'), ('59', '8164'), ('59', '8165'), ('59', '8166'), ('59', '8167'), ('59', '8168'), ('59', '8169'), ('59', '8170'), ('59', '8171'), ('59', '8172'), ('59', '8173'), ('59', '8174'), ('59', '8175'), ('59', '8176'), ('59', '8177'), ('59', '8178'), ('59', '8179'), ('59', '8180'), ('59', '8181'), ('59', '8182'), ('59', '8183'), ('59', '8184'), ('59', '8185'), ('59', '8186'), ('59', '8187'), ('59', '8188'), ('59', '8190'), ('7', '2448'), ('59', '2448'), ('7', '712'), ('59', '712'), ('48', '2503'), ('59', '2503'), ('48', '2013'), ('59', '2013'), ('48', '383'), ('59', '383'), ('7', '7755'), ('7', '8191'), ('7', '8192'), ('7', '8193'), ('7', '8194'), ('7', '8195'), ('7', '8196'), ('7', '8197'), ('7', '8198'), ('7', '8199'), ('7', '8200'), ('7', '8201'), ('7', '8202'), ('7', '8203'), ('7', '8204'), ('7', '8205'), ('7', '8206'), ('7', '8207'), ('9', '8208'), ('7', '8209'), ('7', '8210'), ('7', '8211'), ('7', '8212'), ('7', '8213'), ('7', '8214'), ('7', '8215'), ('7', '8216'), ('7', '8217'), ('7', '8218'), ('7', '8219'), ('48', '8220'), ('7', '8221'), ('7', '8222'), ('7', '8223'), ('7', '8224'), ('7', '8225'), ('7', '8226'), ('7', '8227'), ('7', '8228'), ('7', '8229'), ('7', '8230'), ('7', '8231'), ('7', '8232'), ('7', '8233'), ('7', '8234'), ('7', '8235'), ('7', '8236'), ('7', '8237'), ('7', '8238'), ('7', '8239'), ('7', '8240'), ('7', '8241'), ('7', '8242'), ('7', '8243'), ('7', '8244'), ('7', '8245'), ('7', '8246'), ('7', '8247'), ('50', '832'), ('59', '832'), ('7', '8248'), ('7', '8249'), ('7', '8250'), ('7', '8251'), ('7', '8252'), ('7', '8253'), ('7', '8254'), ('7', '8255'), ('7', '8256'), ('7', '8257'), ('7', '8258'), ('7', '8259'), ('7', '8260'), ('7', '8261'), ('7', '8262'), ('7', '8263'), ('7', '8264'), ('7', '8265'), ('7', '8266'), ('7', '8267');
INSERT INTO `think_flow_type` VALUES ('9', '69', '{SHORT}{YYYY}{M}{D}{######}', '商务审批>10000', 'SW>1W', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498121209', '4', '0', '1', '1', '14', '14', '', '1', '0'), ('10', '69', '{SHORT}{YYYY}{M}{D}{######} ', '商务审批<=2000', 'SW<2K', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498119791', '1', '0', '1', '1', '14', '14', '', '1', '0'), ('11', '69', '{SHORT}{YYYY}{M}{D}{######}', '商务审批>2000<=5000', 'SW<5K', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498121194', '2', '0', '1', '1', '14', '14', '', '1', '0'), ('12', '70', '{SHORT}{YYYY}{M}{D}{######}', '(行政类)合同申请', 'HTYZ', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490252765', '1498475942', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('13', '69', '{SHORT}{YYYY}{M}{D}{######}', '商务审批>5000<=10000 ', 'SW<1W', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498135890', '3', '0', '1', '1', '14', '14', '', '1', '0'), ('14', '70', '{SHORT}{YYYY}{M}{D}{######}', '(行政类)非合同申请', 'FHTYZ', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490252994', '1498127178', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('17', '69', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)商务审批<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1498121219', '5', '0', '1', '1', '15', '15', '', '1', '0'), ('18', '69', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)商务审批>10000', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1498121225', '6', '0', '1', '1', '15', '15', '', '1', '0'), ('19', '72', '{SHORT}{YYYY}{M}{D}{######}', 'IT设备及耗材申请 >10000', 'IT', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490694075', '1498137237', '3', '0', '1', '1', '14', '14', '', '1', '0'), ('20', '72', '{SHORT}{YYYY}{M}{D}{######}', 'IT设备及耗材申请 >5000<=10000', 'IT', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490694293', '1498137221', '2', '0', '1', '1', '14', '14', '', '1', '0'), ('21', '72', '{SHORT}{YYYY}{M}{D}{######}', 'IT设备及耗材申请 >2000<=5000', 'IT', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__38|dsp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490694445', '1498137161', '1', '0', '1', '1', '14', '14', '', '1', '0'), ('22', '72', '{SHORT}{YYYY}{M}{D}{######} ', 'IT设备及耗材申请 <=2000', 'IT<2K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|dsp__38|csp__18|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490694607', '1498131607', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('23', '70', '{SHORT}{YYYY}{M}{D}{######} ', '刻章申请', 'KZ', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|dsp__38|csp__23|csp__41|csp__3|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490695079', '1498131015', '5', '0', '1', '0', '14', '14', '', '1', '0'), ('24', '70', '{SHORT}{YYYY}{M}{D}{######} ', '业务用车配置和处置申请', 'CL', '', 'dgp_16_30|dsp__30|dgp_18_31|dgp_18_32|csp__28|csp__23|csp__38|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'emp_wangli|', '<span data=\"emp_wangli\" id=\"emp_wangli\"><b title=\"王丽/印章保管人\">王丽/印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490695949', '1496884766', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('25', '80', '{SHORT}{YYYY}{M}{D}{######}', '超预算及预算外费用申请', 'CYS', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__41|csp__9|csp__38|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__24|', '<span data=\"csp__24\" id=\"csp__24\"><b title=\"-集团会计\">-集团会计</b><b><i class=\"fa\"></i></b></span>', '1490754730', '1492518862', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('26', '80', '{SHORT}{YYYY}{M}{D}{######}', '(集团)超预算及预算外费用申请 ', 'JTCYS', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_24|', '<span data=\"dgp_19_24\" id=\"dgp_19_24\"><b title=\"集团-集团会计\">集团-集团会计</b><b><i class=\"fa\"></i></b></span>', '1490754947', '1492518876', '2', '0', '1', '0', '15', '15', '', '1', '0'), ('27', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)业务用车配置和处置申请', 'JTCL', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_23|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_23\" id=\"dgp_19_23\"><b title=\"集团-集团行政经理\">集团-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490755566', '1492518852', '4', '0', '1', '0', '15', '15', '', '1', '0'), ('28', '71', '{SHORT}{YYYY}{M}{D}{######} ', '电话费、油费补贴申请', 'BT', '', 'csp__28|dsp__38|dsp__3|csp__21|emp_baiwenjuan|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__21\" id=\"csp__21\"><b title=\"-集团人事经理\">-集团人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_baiwenjuan\" id=\"emp_baiwenjuan\"><b title=\"白文娟/集团行政经理\">白文娟/集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"黄勇/总经理\">黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490758398', '1492786164', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('29', '71', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)电话费、油费补贴申请', 'JTBT', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_21|dgp_19_23|emp_huangyong|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_21\" id=\"dgp_19_21\"><b title=\"集团-集团人事经理\">集团-集团人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_23\" id=\"dgp_19_23\"><b title=\"集团-集团行政经理\">集团-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"黄勇/总经理\">黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490758480', '1492447274', '1', '0', '1', '0', '15', '15', '', '1', '0'), ('30', '70', '{SHORT}{YYYY}{M}{D}{######} ', '劳务费申请(保安/保洁/洗车等人工费)', 'LWFY', '', 'dgp_18_31|csp__28|csp__23|emp_huangyong|csp__41|csp__3|csp__1|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"黄勇/总经理\">黄勇/总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490758812', '1498131188', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('31', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)IT设备及耗材申请 <=10000', 'JTIT<1W', '', 'dsp__28|dsp__38|dsp__9|dgp_19_18|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__19|', '<span data=\"dsp__19\" id=\"dsp__19\"><b title=\"-集团IT主管\">-集团IT主管</b><b><i class=\"fa\"></i></b></span>', '1490759257', '1492781045', '5', '0', '1', '0', '15', '15', '', '1', '0'), ('32', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)IT设备及耗材申请 >10000 ', 'JTIT>1W', '', 'dsp__28|dsp__38|dsp__9|dgp_19_18|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__19|', '<span data=\"dsp__19\" id=\"dsp__19\"><b title=\"-集团IT主管\">-集团IT主管</b><b><i class=\"fa\"></i></b></span>', '1490759329', '1492781112', '5', '0', '1', '0', '15', '15', '', '1', '0'), ('33', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团非IT类)合同申请', 'JTHTYZ', '', 'dsp__28|dsp__9|dsp__38|dgp_19_20|dgp_19_3|dgp_19_1|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_20\" id=\"dgp_19_20\"><b title=\"集团-集团法务\">集团-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490759819', '1498135903', '0', '0', '1', '0', '15', '15', '', '1', '0'), ('34', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)非合同申请', 'JTFHTYZ', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_1|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490760055', '1498127194', '0', '0', '1', '0', '15', '15', '', '1', '0'), ('35', '70', '{SHORT}{YYYY}{M}{D}{######} ', '办公用品领用申请', 'BGYP', '', 'dgp_16_30|dsp__32|dgp_18_31|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490767503', '1498131323', '5', '0', '1', '0', '14', '14', '', '1', '0'), ('36', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)办公用品领用申请', 'JTBGYP', '', 'dsp__28|dsp__9|dsp__18|dsp__38|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|emp_wangli|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span><span data=\"emp_wangli\" id=\"emp_wangli\"><b title=\"王丽/印章保管人\">王丽/印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490767619', '1498131335', '5', '0', '1', '0', '15', '15', '', '1', '0'), ('38', '80', '{SHORT}{YYYY}{M}{D}{######} 　', '资金审批', 'ZJSP', '', 'emp_shilei|', '<span data=\"emp_shilei\" id=\"emp_shilei\"><b title=\"石磊/董事长\">石磊/董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490930767', '1490933914', '0', '0', '1', '0', '17', '17', '', '1', '0'), ('39', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(IT类)合同申请', '(IT类)合同', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__18|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1492271918', '1498475786', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('40', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(非IT类)固定资产<=2000', 'SW<2K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|dsp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498137865', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('41', '70', '{SHORT}{YYYY}{M}{D}{######}', '(非IT类)固定资产>2000<=5000', 'SW<5K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498137979', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('42', '70', '{SHORT}{YYYY}{M}{D}{######}', '(非IT类)固定资产>5000<=10000 ', 'SW<1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|dsp__28|csp__38|csp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498138048', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('43', '70', '{SHORT}{YYYY}{M}{D}{######}', '(非IT类)固定资产>10000', 'SW>1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498138144', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('44', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团非IT类)固定资产<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1493029186', '9', '0', '1', '0', '15', '15', '', '1', '0'), ('45', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团非IT类)固定资产>10000 ', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1493029199', '9', '0', '1', '0', '15', '15', '', '1', '0'), ('47', '80', '{SHORT}{YYYY}{M}{D}{######} ', '店面返佣', '返佣', '', 'dgp_16_30|dsp__31|dsp__32|csp__28|dgp_18_32|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1496217760', '1498135233', '0', '0', '1', '1', '14', '14', '', '1', '0'), ('48', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(IT类)固定资产<=2000', 'SW<2K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|dsp__38|csp__18|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1496851372', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('49', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产>2000<=5000', 'SW<5K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|dsp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1496851655', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('50', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产>5000<=10000 ', 'SW<1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1496851794', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('51', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产>10000', 'SW>1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1496852100', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('52', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团IT类)固定资产<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1496852865', '10', '0', '1', '0', '15', '15', '', '1', '0'), ('53', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团IT类)固定资产>10000 ', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1496852798', '10', '0', '1', '0', '15', '15', '', '1', '0'), ('54', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团IT类)合同申请', 'JTHTYZ', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_20|dgp_19_3|dgp_19_1|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_20\" id=\"dgp_19_20\"><b title=\"集团-集团法务\">集团-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1490759819', '1497349293', '0', '0', '1', '0', '15', '15', '', '1', '0'), ('58', '70', '{SHORT}{YYYY}{M}{D}{######}', '工作服申请', 'GZF', '', 'dgp_18_31|csp__28|csp__23|emp_huangyong|csp__41|csp__3|csp__1|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"黄勇/总经理\">黄勇/总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498121590', '1498131412', '6', '0', '1', '0', '14', '14', '', '1', '0'), ('59', '71', '{SHORT}{YYYY}{M}{D}{######} ', '人事类款项申请(社保/公积金/保险/所得税)', 'RSKX', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_32|', '<span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa\"></i></b></span>', '1498123101', '1498897668', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('60', '80', '{SHORT}{YYYY}{M}{D}{######} ', '(财务类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498123306', '1498476115', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('61', '80', '{SHORT}{YYYY}{M}{D}{######} ', '(财务类)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498123597', '1498127995', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('62', '86', '{SHORT}{YYYY}{M}{D}{######} ', '(集团资金部专用)合同申请', 'HT', '', 'dsp__28|dsp__38|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498123906', '1498151592', '0', '0', '1', '0', '15', '15', '', '1', '0'), ('63', '86', '{SHORT}{YYYY}{M}{D}{######} ', '(集团资金部专用)非合同申请', 'FHT', '', 'dsp__28|dsp__38|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498123955', '1498151674', '0', '0', '1', '0', '15', '15', '', '1', '0'), ('64', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后佣金申请<=2000', 'SHZJ', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('65', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后计入成本类事项申请<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('66', '81', '{SHORT}{YYYY}{M}{D}{######} ', '(售后类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span id=\"csp__40\" data=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124109', '1498476409', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('67', '81', '{SHORT}{YYYY}{M}{D}{######} ', '(售后类)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__32\" data=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_31\" data=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__23\" data=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__1\" data=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span id=\"csp__40\" data=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124135', '1498153740', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('72', '82', '{SHORT}{YYYY}{M}{D}{######} ', '试乘试驾新增申请', 'SCSJ', '', 'dgp_16_30|dsp__30|dgp_18_31|dgp_18_32|csp__28|csp__23|csp__38|csp__3|csp__1|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_31\" data=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__23\" data=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__1\" data=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_40|', '<span id=\"dgp_19_40\" data=\"dgp_19_40\"><b title=\"集团-印章保管人\">集团-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124325', '1498153461', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('73', '82', '{SHORT}{YYYY}{M}{D}{######} ', '试乘试驾处置申请', 'CSCJCZ', '', 'dgp_16_30|dsp__30|dgp_18_31|dgp_18_32|csp__28|csp__23|csp__38|csp__3|csp__1|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_31\" data=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__23\" data=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__1\" data=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498124357', '1498153476', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('74', '82', '{SHORT}{YYYY}{M}{D}{######} ', '(库存当量<=1.5)整车款支付资金申请', 'KCZJ', '', 'dgp_16_30|dgp_18_32|csp__28|csp__38|csp__41|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_32|', '<span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa\"></i></b></span>', '1498124417', '1498154348', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('75', '82', '{SHORT}{YYYY}{M}{D}{######} ', '(库存当量>1.5)整车款支付资金申请', 'KCZJ', '', 'dgp_16_30|dsp__32|csp__28|csp__38|csp__41|emp_wanglk|csp__3|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_wanglk\" id=\"emp_wanglk\"><b title=\"AE01.王林昆/总经理\">AE01.王林昆/总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_32|', '<span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa\"></i></b></span>', '1498124485', '1503386467', '1', '0', '1', '0', '14', '14', '', '1', '0');
INSERT INTO `think_flow_type` VALUES ('76', '82', '{SHORT}{YYYY}{M}{D}{######} ', '退订金申请<=2000', 'SW<2K', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '2', '0', '1', '0', '14', '14', '', '1', '0'), ('77', '82', '{SHORT}{YYYY}{M}{D}{######} ', '商品车费用申请<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('78', '82', '{SHORT}{YYYY}{M}{D}{######} ', '调车支付款项申请<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('79', '83', '{SHORT}{YYYY}{M}{D}{######} ', '(市场专用)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|csp__42|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__42\" id=\"csp__42\"><b title=\"-市场督导\">-市场督导</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124702', '1498477285', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('80', '83', '{SHORT}{YYYY}{M}{D}{######} ', '(市场专用)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__42|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__42\" id=\"csp__42\"><b title=\"-市场督导\">-市场督导</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124748', '1498153007', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('81', '84', '{SHORT}{YYYY}{M}{D}{######} ', '(客服类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__20|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124786', '1498153052', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('82', '84', '{SHORT}{YYYY}{M}{D}{######} ', '(客服类)非合同申请', 'FEHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124816', '1498153076', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('83', '85', '{SHORT}{YYYY}{M}{D}{######} ', '(增值业务类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124845', '1498491244', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('84', '85', '{SHORT}{YYYY}{M}{D}{######} ', '(增值业务类)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124870', '1498464337', '1', '0', '1', '0', '14', '14', '', '1', '0'), ('86', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(非IT类)固定资产报废和处理申请>10000', 'GDZC', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498126437', '1498146904', '11', '0', '1', '0', '14', '14', '', '1', '0'), ('87', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(非IT类)固定资产报废和处置申请>5000<=10000', 'GDZC', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__32\" data=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498126511', '1498153487', '11', '0', '1', '0', '14', '14', '', '1', '0'), ('88', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(非IT类)固定资产报废和处置申请>2000<=5000', 'DGDZC', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498126611', '1498146325', '11', '0', '1', '0', '14', '14', '', '1', '0'), ('89', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(非IT类)固定资产报废和处置申请<=2000', 'GDZC', '', 'dgp_16_30|dsp__30|dsp__31|csp__32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__32\" id=\"csp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1498126669', '1498146955', '11', '0', '1', '0', '14', '14', '', '1', '0'), ('94', '82', '{SHORT}{YYYY}{M}{D}{######} ', '(销售类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span id=\"csp__40\" data=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498128196', '1498476241', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('95', '82', '{SHORT}{YYYY}{M}{D}{######} ', '(销售类)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|dgp_18_31|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__32\" data=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_31\" data=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__23\" data=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__1\" data=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span id=\"csp__40\" data=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498128223', '1498153771', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('96', '82', '{SHORT}{YYYY}{M}{D}{######}', '退订金申请>2000<=5000', 'SW<5K', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '2', '0', '1', '0', '14', '14', '', '1', '0'), ('97', '82', '{SHORT}{YYYY}{M}{D}{######}', '退订金申请>5000<=10000 ', 'SW<1W', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154034', '2', '0', '1', '0', '14', '14', '', '1', '0'), ('98', '82', '{SHORT}{YYYY}{M}{D}{######}', '退订金申请>10000', 'SW>1W', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498150600', '2', '0', '1', '0', '14', '14', '', '1', '0'), ('99', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后佣金申请>2000<=5000', 'SHZJ', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('100', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后佣金申请>5000<=10000 ', 'SHZJ', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498153932', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('101', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后佣金申请>10000', 'SHZJ', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__9|csp__41|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498150089', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('102', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后计入成本类事项申请>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('103', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后计入成本类事项申请>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498153887', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('104', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后计入成本类事项申请>10000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498149929', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('105', '82', '{SHORT}{YYYY}{M}{D}{######} ', '调车支付款项申请>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('106', '82', '{SHORT}{YYYY}{M}{D}{######} ', '调车支付款项申请>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154540', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('107', '82', '{SHORT}{YYYY}{M}{D}{######} ', '调车支付款项申请>10000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498151232', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('108', '82', '{SHORT}{YYYY}{M}{D}{######} ', '商品车费用申请>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('109', '82', '{SHORT}{YYYY}{M}{D}{######} ', '商品车费用申请>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154076', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('110', '82', '{SHORT}{YYYY}{M}{D}{######} ', '商品车费用申请>10000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498150773', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('111', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-个人佣金申请及支付<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('112', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-个人佣金申请及支付>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('113', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-个人佣金申请及支付>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154512', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('114', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-个人佣金申请及支付>10000', 'SHCB', '', 'dgp_16_30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498151001', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('115', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-大客户和二网佣金申请及支付<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('116', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-大客户和二网佣金申请及支付>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('117', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-大客户和二网佣金申请及支付>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498153946', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('118', '82', '{SHORT}{YYYY}{M}{D}{######} ', '整车-大客户和二网佣金申请及支付>10000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498151445', '4', '0', '1', '0', '14', '14', '', '1', '0'), ('119', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团非IT类)固定资产报废和处理申请<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1493029186', '9', '0', '1', '0', '15', '15', '', '1', '0'), ('120', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团非IT类)固定资产报废和处理申请>10000 ', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1496852798', '10', '0', '1', '0', '15', '15', '', '1', '0'), ('121', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(IT类)固定资产报废和处理申请<=2000', 'SW<2K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|dsp__38|csp__18|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1496851372', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('122', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产报废和处理申请>2000<=5000', 'SW<5K', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|dsp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1496851655', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('123', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产报废和处理申请>5000<=10000 ', 'SW<1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1496851794', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('124', '72', '{SHORT}{YYYY}{M}{D}{######}', '(IT类)固定资产报废和处理申请>10000', 'SW>1W', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__18|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1496852100', '9', '0', '1', '0', '14', '14', '', '1', '0'), ('125', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团IT类)固定资产报废和处理申请<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1496852865', '10', '0', '1', '0', '15', '15', '', '1', '0'), ('126', '72', '{SHORT}{YYYY}{M}{D}{######} ', '(集团IT类)固定资产报废和处理申请>10000 ', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__38|dgp_19_18|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_18\" id=\"dgp_19_18\"><b title=\"集团-集团信息部总经理\">集团-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1496852798', '10', '0', '1', '0', '15', '15', '', '1', '0'), ('127', '70', '{SHORT}{YYYY}{M}{D}{######} ', '员工福利费<=2000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|dsp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252411', '1498139614', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('128', '70', '{SHORT}{YYYY}{M}{D}{######} ', '员工福利费>2000<=5000', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252504', '1498139816', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('129', '70', '{SHORT}{YYYY}{M}{D}{######} ', '员工福利费>5000<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154512', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('130', '70', '{SHORT}{YYYY}{M}{D}{######} ', '员工福利费>10000', 'SHCB', '', 'dgp_16_30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498151001', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('131', '70', '{SHORT}{YYYY}{M}{D}{######} ', '长期待摊费<=10000 ', 'SHCB', '', 'dgp_16_30|dsp__30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__41|csp__9|', '<span id=\"dgp_16_30\" data=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__30\" data=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dsp__31\" data=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"dgp_18_32\" data=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__28\" data=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__38\" data=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__3\" data=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__41\" data=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span id=\"csp__9\" data=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1498154512', '3', '0', '1', '0', '14', '14', '', '1', '0'), ('132', '70', '{SHORT}{YYYY}{M}{D}{######} ', '长期待摊费>10000', 'SHCB', '', 'dgp_16_30|dsp__31|dgp_18_32|csp__28|csp__38|csp__3|csp__1|csp__41|csp__9|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1498151001', '3', '0', '1', '0', '14', '14', '', '1', '0');
INSERT INTO `think_flow_type` VALUES ('133', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)员工福利费<=10000', 'JTSW', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490690935', '1498206501', '6', '0', '1', '0', '15', '15', '', '1', '0'), ('134', '70', '{SHORT}{YYYY}{M}{D}{######} ', '(集团)员工福利费>10000', 'JTSW>1W', '', 'dsp__28|dsp__9|dsp__18|dsp__38|dgp_19_3|dgp_19_1|dgp_19_9|', '<span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_3\" id=\"dgp_19_3\"><b title=\"集团-CEO\">集团-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_1\" id=\"dgp_19_1\"><b title=\"集团-董事长\">集团-董事长</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_19_9\" id=\"dgp_19_9\"><b title=\"集团-集团财务总经理\">集团-集团财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490691063', '1498206483', '6', '0', '1', '0', '15', '15', '', '1', '0'), ('135', '85', '{SHORT}{YYYY}{M}{D}{######} ', '(保险类)合同申请', 'HT', '', 'dgp_16_30|dsp__30|dsp__32|emp_chenyunyan|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_chenyunyan\" id=\"emp_chenyunyan\"><b title=\"陈云雁/副总经理\">陈云雁/副总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124845', '1498536319', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('136', '85', '{SHORT}{YYYY}{M}{D}{######} ', '(保险类)非合同申请', 'FHT', '', 'dgp_16_30|dsp__30|dsp__32|emp_chenyunyan|dgp_18_31|csp__20|csp__28|csp__23|csp__38|csp__41|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_chenyunyan\" id=\"emp_chenyunyan\"><b title=\"陈云雁/副总经理\">陈云雁/副总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__20\" id=\"csp__20\"><b title=\"-集团法务\">-集团法务</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__40|', '<span data=\"csp__40\" id=\"csp__40\"><b title=\"-印章保管人\">-印章保管人</b><b><i class=\"fa\"></i></b></span>', '1498124870', '1498536484', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('137', '85', '{SHORT}{YYYY}{M}{D}{######} ', '（增值业务类）支付款项申请>10000', 'SHCB', '', 'emp_ranqixian|csp__9|csp__38|csp__3|csp__1|', '<span data=\"emp_ranqixian\" id=\"emp_ranqixian\"><b title=\"冉啟娴/财务经理\">冉啟娴/财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252880', '1500369625', '3', '0', '1', '0', '18', '18', '', '1', '0'), ('138', '85', '{SHORT}{YYYY}{M}{D}{######} ', '（增值业务类）支付款项申请<=10000', 'SHCB', '', 'emp_ranqixian|csp__9|csp__38|csp__3|', '<span data=\"emp_ranqixian\" id=\"emp_ranqixian\"><b title=\"冉啟娴/财务经理\">冉啟娴/财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__9\" id=\"csp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1490252282', '1500369453', '3', '0', '1', '0', '18', '18', '', '1', '0'), ('139', '82', '{SHORT}{YYYY}{M}{D}{######}', '二网审批', '二网审批', '', 'dgp_16_30|csp__28|emp_zhongming|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_zhongming\" id=\"emp_zhongming\"><b title=\"AA06.钟鸣/副总裁\">AA06.钟鸣/副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_32|emp_yuanfang|', '<span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa\"></i></b></span><span data=\"emp_yuanfang\" id=\"emp_yuanfang\"><b title=\"AT03.原方/总经理\">AT03.原方/总经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502777280', '1', '0', '1', '0', '15', '15', '', '1', '0'), ('140', '90', '员工级', '异常反馈', '员工级', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503279837', '2', '0', '1', '0', '19', '19', '', '1', '1'), ('141', '90', '经理级', '异常反馈', 'DMJL', '', 'csp__28|dsp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503279953', '3', '0', '1', '0', '20', '20', '', '1', '1'), ('142', '90', '店总经理', '异常反馈', 'DMZJL', '', 'csp__38|dsp__38|dsp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502948559', '4', '0', '1', '0', '21', '21', '', '1', '1'), ('143', '90', '集团员工', '异常反馈', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504717127', '5', '0', '1', '0', '22', '22', '', '1', '1'), ('144', '90', '(集团总经理)', '异常反馈', 'JTZJL', '', 'dsp__38|dsp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678311', '6', '0', '1', '0', '23', '23', '', '1', '1'), ('145', '90', '(高管)', '异常反馈', 'JTGG', '', 'csp__1|', '<span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678331', '7', '0', '1', '0', '24', '24', '', '1', '1'), ('146', '94', '员工级', '外出申请', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678688', '8', '0', '1', '0', '19', '19', '', '1', '5'), ('147', '94', '经理级', '外出申请', 'DMJL', '', 'csp__28|dsp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503280686', '9', '0', '1', '0', '20', '20', '', '1', '5'), ('148', '94', '(店总经理)', '外出申请', 'DMZJL', '', 'csp__38|dsp__38|dsp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504169380', '10', '0', '1', '0', '21', '21', '', '1', '5'), ('149', '94', '集团员工', '外出申请', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504716201', '11', '0', '1', '0', '22', '22', '', '1', '5'), ('150', '94', '(集团总经理)', '外出申请', 'JTZJL', '', 'dsp__38|dsp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678752', '12', '0', '1', '0', '23', '23', '', '1', '5'), ('151', '94', '(高管)', '外出申请', 'JTGG', '', 'csp__1|', '<span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678764', '13', '0', '1', '0', '24', '24', '', '1', '5'), ('152', '92', '员工级', '调休申请', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678445', '14', '0', '1', '0', '19', '19', '', '1', '3'), ('153', '92', '经理级', '调休申请', 'DMJL', '', 'csp__28|dsp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503281466', '15', '0', '1', '0', '20', '20', '', '1', '3'), ('154', '92', '(店总经理)', '调休申请', 'DMZJL', '', 'csp__38|dsp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678473', '16', '0', '1', '0', '21', '21', '', '1', '3'), ('155', '92', '集团员工', '调休申请', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504716084', '17', '0', '1', '0', '22', '22', '', '1', '3'), ('156', '92', '(集团总经理)', '调休申请', 'JTZJL', '', 'dsp__38|dsp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678501', '18', '0', '1', '0', '23', '23', '', '1', '3'), ('157', '92', '(高管)', '调休申请', 'JTGG', '', 'csp__1|', '<span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678520', '19', '0', '1', '0', '24', '24', '', '1', '3'), ('158', '91', '员工级', '加班申请', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678349', '20', '0', '1', '0', '19', '19', '', '1', '2'), ('159', '91', '经理级', '加班申请', 'DMJL', '', 'csp__28|dsp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503280765', '21', '0', '1', '0', '20', '20', '', '1', '2'), ('160', '91', '(店总经理)', '加班申请', 'DMZJL', '', 'csp__38|dsp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678385', '22', '0', '1', '0', '21', '21', '', '1', '2'), ('161', '91', '集团员工', '加班申请', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504716028', '23', '0', '1', '0', '22', '22', '', '1', '2'), ('162', '91', '(集团总经理)', '加班申请', 'JTZJL', '', 'dsp__38|dsp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678417', '24', '0', '1', '0', '23', '23', '', '1', '2'), ('163', '91', '(高管)', '加班申请', 'JTGG', '', 'csp__1|', '<span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678431', '25', '0', '1', '0', '24', '24', '', '1', '2'), ('164', '93', '员工级', '请假申请<=3天', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678538', '26', '0', '1', '0', '19', '19', '', '1', '4'), ('165', '93', '经理级', '请假申请<=3天', 'DMJL', '', 'csp__28|dsp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503280040', '27', '0', '1', '0', '20', '20', '', '1', '4'), ('166', '93', '(店总经理)', '请假申请', 'DMZJL', '', 'csp__38|dsp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678570', '28', '0', '1', '0', '21', '21', '', '1', '4'), ('167', '93', '集团员工', '请假申请<=3天', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504716124', '29', '0', '1', '0', '22', '22', '', '1', '4'), ('168', '93', '(集团总经理)', '请假申请', 'JTZJL', '', 'dsp__38|dsp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__26|', '<span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678597', '30', '0', '1', '0', '23', '23', '', '1', '4'), ('169', '93', '员工级', '请假申请>3天', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503279727', '31', '0', '1', '0', '19', '19', '', '1', '4'), ('170', '93', '经理级', '请假申请>3天', 'DMJL', '', 'csp__28|csp__38|dsp__41|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503280320', '32', '0', '1', '0', '20', '20', '', '1', '4'), ('171', '93', '集团员工', '请假申请>3天', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504716156', '33', '0', '1', '0', '22', '22', '', '1', '4'), ('172', '93', '(高管)', '请假申请', 'JTGG', '', 'csp__3|csp__1|', '<span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505822679', '34', '0', '1', '0', '24', '24', '', '1', '4'), ('173', '95', '员工级', '出差申请(未超标)', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__32|dsp__31|dsp__41|csp__28|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505836159', '35', '0', '1', '0', '19', '19', '', '1', '6'), ('174', '95', '经理级', '出差申请(未超标)', 'DMJL', '', 'csp__28|dsp__41|csp__38|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__41\" id=\"dsp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505797827', '36', '0', '1', '0', '20', '20', '', '1', '6'), ('175', '95', '(店总经理)', '出差申请', 'DMZJL', '', 'csp__38|csp__3|', '<span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dgp_19_26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505824255', '37', '0', '1', '0', '21', '21', '', '1', '6'), ('176', '95', '集团员工', '出差申请(未超标)', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|dsp__38|dsp__3|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__3\" id=\"dsp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505798618', '38', '0', '1', '0', '22', '22', '', '1', '6'), ('177', '95', '(集团总经理)', '出差申请', 'JTZJL', '', 'dsp__38|csp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505799151', '39', '0', '1', '0', '23', '23', '', '1', '6'), ('178', '95', '员工级', '出差申请(超标准)', 'DMYG', '', 'dgp_16_30|dsp__30|dsp__31|dsp__32|csp__28|csp__38|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__32\" id=\"dsp__32\"><b title=\"-财务经理\">-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505823228', '40', '0', '1', '0', '19', '19', '', '1', '6'), ('179', '95', '经理级', '出差申请(超标准)', 'DMJL', '', 'csp__28|csp__38|csp__41|csp__3|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__41\" id=\"csp__41\"><b title=\"-广汇财务总经理\">-广汇财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505823462', '41', '0', '1', '0', '20', '20', '', '1', '6'), ('180', '95', '集团员工', '出差申请(超标准)', 'JTYG', '', 'dsp__18|dsp__9|dsp__28|dsp__38|csp__3|', '<span data=\"dsp__18\" id=\"dsp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__9\" id=\"dsp__9\"><b title=\"-集团财务总经理\">-集团财务总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__28\" id=\"dsp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505833960', '42', '0', '1', '0', '22', '22', '', '1', '6'), ('181', '95', '(高管)', '出差申请', 'JTGG', '', 'csp__3|csp__1|', '<span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_19_26|', '<span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505824335', '43', '0', '1', '0', '24', '24', '', '1', '6'), ('182', '85', '{SHORT}{YYYY}{M}{D}{######}', '(装饰类)精品付款审批 ', 'JPZS', '', 'csp__28|emp_liurenzhong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_liurenzhong\" id=\"emp_liurenzhong\"><b title=\"A01.刘任重/副总裁\">A01.刘任重/副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_32|', '<span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa\"></i></b></span>', '0', '1502343440', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('183', '90', '店面行政经理', '异常反馈', 'DMJL', '', 'csp__28|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505876426', '44', '0', '1', '0', '26', '26', '', '1', '1'), ('184', '94', '店面行政经理', '外出申请', 'DMJL', '', 'csp__28|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504886318', '44', '0', '1', '0', '26', '26', '', '1', '5'), ('185', '92', '店面行政经理', '调休申请', 'DMJL', '', 'csp__28|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504886166', '44', '0', '1', '0', '26', '26', '', '1', '3'), ('186', '91', '店面行政经理', '加班申请', 'DMJL', '', 'csp__28|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504886107', '44', '0', '1', '0', '26', '26', '', '1', '2'), ('187', '93', '店面行政经理', '请假申请<=3天', 'DMJL', '', 'csp__28|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505822982', '44', '0', '1', '0', '26', '26', '', '1', '4'), ('188', '93', '店面行政经理', '请假申请>3天', 'DMJL', '', 'csp__28|csp__38|csp__3|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505823799', '44', '0', '1', '0', '26', '26', '', '1', '4'), ('189', '95', '店面行政经理', '出差申请(未超标)', 'DMJL', '', 'csp__28|csp__38|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dgp_19_26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505834111', '44', '0', '1', '0', '26', '26', '', '1', '6'), ('190', '95', '店面行政经理', '出差申请(超标准)', 'DMJL', '', 'csp__28|csp__38|csp__3|emp_huangyong|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_huangyong\" id=\"emp_huangyong\"><b title=\"AC01.黄勇/总经理\">AC01.黄勇/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dgp_19_26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505834082', '44', '0', '1', '0', '26', '26', '', '1', '6'), ('191', '90', '店面IT', '异常反馈', 'DMYG', '', 'dsp__31|dgp_16_30|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740014', '44', '0', '1', '0', '25', '25', '', '1', '1'), ('192', '94', '店面IT', '外出申请', 'DMYG', '', 'dsp__31|dgp_16_30|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740419', '44', '0', '1', '0', '25', '25', '', '1', '5'), ('193', '92', '店面IT', '调休申请', 'DMYG', '', 'dsp__31|dgp_16_30|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740114', '44', '0', '1', '0', '25', '25', '', '1', '3'), ('194', '91', '店面IT', '加班申请', 'DMYG', '', 'dsp__31|dgp_16_30|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740072', '44', '0', '1', '0', '25', '25', '', '1', '2'), ('195', '93', '店面IT', '请假申请<=3天', 'DMYG', '', 'dsp__31|dgp_16_30|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740249', '44', '0', '1', '0', '25', '25', '', '1', '4'), ('196', '93', '店面IT', '请假申请>3天', 'DMYG', '', 'dsp__31|dgp_16_30|csp__28|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505740369', '44', '0', '1', '0', '25', '25', '', '1', '4'), ('197', '95', '店面IT', '出差申请(未超标)', 'DMYG', '', 'dsp__31|dsp__30|csp__28|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505824500', '44', '0', '1', '0', '25', '25', '', '1', '6'), ('198', '95', '店面IT', '出差申请(超标准)', 'DMYG', '', 'dsp__31|dsp__30|csp__28|csp__38|csp__18|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dsp__31|', '<span data=\"dsp__31\" id=\"dsp__31\"><b title=\"-店面行政/人事经理\">-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505824583', '44', '0', '1', '0', '25', '25', '', '1', '6'), ('199', '90', '店面保险索赔', '异常反馈', 'DMYG', '', 'emp_huangxi|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505309834', '44', '0', '1', '0', '27', '27', '', '1', '1'), ('200', '94', '店面保险索赔', '外出申请', 'DMYG', '', 'emp_huangxi|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505310119', '44', '0', '1', '0', '27', '27', '', '1', '5'), ('201', '92', '店面保险索赔', '调休申请', 'DMYG', '', 'emp_huangxi|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505309947', '44', '0', '1', '0', '27', '27', '', '1', '3'), ('202', '91', '店面保险索赔', '加班申请', 'DMYG', '', 'emp_huangxi|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505309886', '44', '0', '1', '0', '27', '27', '', '1', '2'), ('203', '93', '店面保险索赔', '请假申请<=3天', 'DMYG', '', 'emp_huangxi|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505310001', '44', '0', '1', '0', '27', '27', '', '1', '4'), ('204', '93', '店面保险索赔', '请假申请>3天', 'DMYG', '', 'emp_huangxi|emp_chenyunyan|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_chenyunyan\" id=\"emp_chenyunyan\"><b title=\"AH02.陈云雁/总经理\">AH02.陈云雁/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505310062', '44', '0', '1', '0', '27', '27', '', '1', '4'), ('205', '95', '店面保险索赔', '出差申请(未超标)', 'DMYG', '', 'emp_huangxi|emp_chenyunyan|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_chenyunyan\" id=\"emp_chenyunyan\"><b title=\"AH02.陈云雁/总经理\">AH02.陈云雁/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505835362', '44', '0', '1', '0', '27', '27', '', '1', '6'), ('206', '95', '店面保险索赔', '出差申请(超标准)', 'DMYG', '', 'emp_huangxi|emp_chenyunyan|', '<span data=\"emp_huangxi\" id=\"emp_huangxi\"><b title=\"AH03.黄曦/员工\">AH03.黄曦/员工</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"emp_chenyunyan\" id=\"emp_chenyunyan\"><b title=\"AH02.陈云雁/总经理\">AH02.陈云雁/总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dsp__26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dsp__26\" id=\"dsp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505310342', '44', '0', '1', '0', '27', '27', '', '1', '6'), ('207', '90', '集团员工(副总裁直管)', '异常反馈', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503279837', '44', '0', '1', '0', '28', '28', '', '1', '1'), ('208', '94', '集团员工(副总裁直管)', '外出申请', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678688', '44', '0', '1', '0', '28', '28', '', '1', '5'), ('209', '92', '集团员工(副总裁直管)', '调休申请', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1504715727', '44', '0', '1', '0', '28', '28', '', '1', '3'), ('210', '91', '集团员工(副总裁直管)', '加班申请', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678349', '44', '0', '1', '0', '28', '28', '', '1', '2'), ('211', '93', '集团员工(副总裁直管)', '请假申请<=3天', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678538', '44', '0', '1', '0', '28', '28', '', '1', '4'), ('212', '93', '集团员工(副总裁直管)', '请假申请>3天', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1503279727', '44', '0', '1', '0', '28', '28', '', '1', '4'), ('213', '95', '集团员工(副总裁直管)', '出差申请(未超标)', 'DMYG', '', 'dsp__38|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1502678778', '44', '0', '1', '0', '28', '28', '', '1', '6'), ('214', '95', '集团员工(副总裁直管)', '出差申请(超标准)', 'DMYG', '', 'dsp__38|csp__3|', '<span data=\"dsp__38\" id=\"dsp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', 'csp__26|', '<span data=\"csp__26\" id=\"csp__26\"><b title=\"-集团前台\">-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505833323', '44', '0', '1', '0', '28', '28', '', '1', '6'), ('215', '90', '店面IT经理级', '异常反馈', 'DMYG', '', 'csp__28|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505403653', '44', '0', '1', '0', '29', '29', '', '1', '1'), ('216', '94', '店面IT经理级', '外出申请', 'DMYG', '', 'csp__28|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505404056', '44', '0', '1', '0', '29', '29', '', '1', '5'), ('217', '92', '店面IT经理级', '调休申请', 'DMYG', '', 'csp__28|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505403824', '44', '0', '1', '0', '29', '29', '', '1', '3'), ('218', '91', '店面IT经理级', '加班申请', 'DMYG', '', 'csp__28|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505403728', '44', '0', '1', '0', '29', '29', '', '1', '2'), ('219', '93', '店面IT经理级', '请假申请<=3天', 'DMYG', '', 'csp__28|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505403912', '44', '0', '1', '0', '29', '29', '', '1', '4'), ('220', '93', '店面IT经理级', '请假申请>3天', 'DMYG', '', 'csp__28|csp__38|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505403996', '44', '0', '1', '0', '29', '29', '', '1', '4'), ('221', '95', '店面IT经理级', '出差申请(未超标)', 'DMYG', '', 'csp__28|csp__38|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dgp_19_26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505833267', '44', '0', '1', '0', '29', '29', '', '1', '6'), ('222', '95', '店面IT经理级', '出差申请(超标准)', 'DMYG', '', 'csp__28|csp__38|csp__3|csp__18|', '<span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__18\" id=\"csp__18\"><b title=\"-集团信息部总经理\">-集团信息部总经理</b><b><i class=\"fa\"></i></b></span>', '', '', 'dgp_18_31|dgp_19_26|', '<span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa\"></i></b></span><span data=\"dgp_19_26\" id=\"dgp_19_26\"><b title=\"集团-集团前台\">集团-集团前台</b><b><i class=\"fa\"></i></b></span>', '1490252282', '1505833205', '44', '0', '1', '0', '29', '29', '', '1', '6'), ('223', '81', '{SHORT}{YYYY}{M}{D}{######} ', '售后服务车、客户代步车申请及处置', '售后服务车、客户代步车申请及处置', '', 'dgp_16_30|dgp_18_31|dgp_18_32|csp__28|csp__23|csp__38|csp__3|csp__1|', '<span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_31\" id=\"dgp_18_31\"><b title=\"公司-店面行政/人事经理\">公司-店面行政/人事经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_18_32\" id=\"dgp_18_32\"><b title=\"公司-财务经理\">公司-财务经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__23\" id=\"csp__23\"><b title=\"-集团行政经理\">-集团行政经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__1\" id=\"csp__1\"><b title=\"-董事长\">-董事长</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1505801034', '1505813231', '0', '0', '1', '0', '14', '14', '', '1', '0'), ('224', '81', '{SHORT}{YYYY}{M}{D}{######} ', '备件外销、减值审批', '备件审批', '', 'dgp_18_45|dgp_16_30|dsp__30|csp__28|csp__38|csp__3|', '<span data=\"dgp_18_45\" id=\"dgp_18_45\"><b title=\"公司-备件经理\">公司-备件经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dgp_16_30\" id=\"dgp_16_30\"><b title=\"部门-部门经理\">部门-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"dsp__30\" id=\"dsp__30\"><b title=\"-部门经理\">-部门经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__28\" id=\"csp__28\"><b title=\"-总经理\">-总经理</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__38\" id=\"csp__38\"><b title=\"-副总裁\">-副总裁</b><b><i class=\"fa fa-arrow-right\"></i></b></span><span data=\"csp__3\" id=\"csp__3\"><b title=\"-CEO\">-CEO</b><b><i class=\"fa\"></i></b></span>', '', '', '', '', '1506065161', '1506085075', '0', '0', '1', '0', '14', '14', '', '1', '0');
INSERT INTO `think_udf_field` VALUES ('244', '金额:', '9', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('245', '金额:', '10', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('246', '金额:', '11', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('247', '金额:', '17', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('248', '金额:', '13', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('249', '金额:', '18', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('250', '加盖何种印章:', '12', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('251', '用印文件名称:', '12', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('252', '文件份数:', '12', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('253', '合同供需单位:', '12', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('254', '加盖何种印章:', '14', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('255', '文件名称:', '14', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('256', '文件份数:', '14', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('257', '合同总金额:', '14', '4', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('258', '印章内容:', '23', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('259', '预计金额:', '35', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('260', '总金额:', '30', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('261', '费用类型:', '30', '', '', 'text', '', '2', '保安费/保洁费/洗车费/', 'require', 'Flow', '0', ''), ('262', '总金额:', '22', '1', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('263', '使用部门:', '22', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('264', '数量:', '22', '0', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('265', '总金额', '38', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('266', '金额:', '19', '11', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('267', '数量:', '19', '0', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('268', '数量：', '20', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('269', '金额：', '20', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('270', '数量：', '21', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('271', '金额：', '21', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('272', '数量', '31', '', '', 'number', '', '2', '', 'require', 'Flow', '0', ''), ('273', '金额', '31', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('274', '使用部门', '31', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('275', '数量', '32', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('276', '金额', '32', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('277', '使用部门', '32', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('278', '数量:', '36', '', '', 'number', '', '2', '', 'require', 'Flow', '0', ''), ('279', '金额:', '36', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('280', '金额', '48', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('281', '合同总金额:', '12', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('282', '合同总金额:', '39', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('283', '加盖何种印章:', '39', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('284', '用印文件名称:', '39', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('285', '文件份数:', '39', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('286', '合同供需单位:', '39', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('287', '合同总金额:', '33', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('288', '加盖何种印章:', '33', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('289', '用印文件名称:', '33', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('290', '文件份数:', '33', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('291', '合同供需单位:', '33', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('292', '合同总金额:', '54', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('293', '加盖何种印章:', '54', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('294', '用印文件名称:', '54', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('295', '文件份数:', '54', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('296', '合同供需单位:', '54', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('297', '合同总金额:', '60', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('298', '加盖何种印章:', '60', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('299', '用印文件名称:', '60', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('300', '文件份数:', '60', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('301', '合同供需单位:', '60', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('302', '合同总金额:', '66', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('303', '加盖何种印章:', '66', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('304', '用印文件名称:', '66', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('305', '文件份数:', '66', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('306', '合同供需单位:', '66', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('307', '合同总金额:', '94', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('308', '加盖何种印章:', '94', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('309', '用印文件名称:', '94', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('310', '文件份数:', '94', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('311', '合同供需单位:', '94', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('312', '合同总金额:', '79', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('313', '加盖何种印章:', '79', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('314', '用印文件名称:', '79', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('315', '文件份数:', '79', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('316', '合同供需单位:', '79', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('317', '合同总金额:', '81', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('318', '加盖何种印章:', '81', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('319', '用印文件名称:', '81', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('320', '文件份数:', '81', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('321', '合同供需单位:', '81', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('322', '合同总金额:', '83', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('323', '加盖何种印章:', '83', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('324', '用印文件名称:', '83', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('325', '文件份数:', '83', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('326', '合同供需单位:', '83', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('327', '合同总金额:', '62', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('328', '加盖何种印章:', '62', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('329', '用印文件名称:', '62', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('330', '文件份数:', '62', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('331', '合同供需单位:', '62', '4', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('332', '合同总金额:', '34', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('333', '加盖何种印章:', '34', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('334', '用印文件名称:', '34', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('335', '文件份数:', '34', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('336', '合同总金额:', '61', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('337', '加盖何种印章:', '61', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('338', '用印文件名称:', '61', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('339', '文件份数:', '61', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('340', '合同总金额:', '67', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('341', '加盖何种印章:', '67', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('342', '用印文件名称:', '67', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('343', '文件份数:', '67', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('344', '合同总金额:', '95', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('345', '加盖何种印章:', '95', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('346', '用印文件名称:', '95', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('347', '文件份数:', '95', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('348', '合同总金额:', '80', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('349', '加盖何种印章:', '80', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('350', '用印文件名称:', '80', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('351', '文件份数:', '80', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('352', '合同总金额:', '82', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('353', '加盖何种印章:', '82', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('354', '用印文件名称:', '82', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('355', '文件份数:', '82', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('356', '合同总金额:', '84', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('357', '加盖何种印章:', '84', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('358', '用印文件名称:', '84', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('359', '文件份数:', '84', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('360', '合同总金额:', '63', '5', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('361', '加盖何种印章:', '63', '1', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('362', '用印文件名称:', '63', '2', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('363', '文件份数:', '63', '3', '', 'number', '份', '2', '', 'require', 'Flow', '0', ''), ('364', '金额:', '40', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('365', '金额:', '44', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('366', '金额:', '127', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('367', '金额:', '131', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('368', '金额:', '133', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('370', '金额:', '29', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('371', '金额:', '59', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('373', '金额:', '52', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('374', '金额:', '64', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('375', '金额:', '65', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('376', '金额:', '74', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('377', '金额:', '75', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('378', '金额:', '76', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('379', '金额:', '77', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('380', '金额:', '78', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('381', '金额:', '111', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('382', '金额:', '115', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('383', '金额:', '25', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('384', '金额:', '26', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('385', '总金额', '89', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('386', '总金额', '119', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('389', '总金额', '121', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('390', '总金额', '125', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('391', '总金额', '58', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('392', '总金额', '128', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('393', '总金额', '129', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('394', '总金额：', '130', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('395', '总金额:', '132', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('396', '总金额：', '134', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('397', '总金额：', '41', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('398', '总金额：', '42', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('399', '总金额：', '43', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('400', '金额：', '45', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('401', '金额：', '120', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('402', '总金额：', '86', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('403', '总金额：', '88', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('404', '总金额：', '102', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('405', '总金额：', '103', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('406', '总金额：', '104', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('407', '总金额：', '99', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('408', '总金额：', '100', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('409', '总金额：', '101', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('410', '总金额：', '96', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('411', '总金额：', '97', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('412', '总金额：', '98', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('413', '总金额：', '108', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('414', '总金额：', '109', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('415', '总金额：', '110', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('416', '总金额：', '112', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('417', '总金额：', '113', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('418', '总金额：', '105', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('419', '总金额：', '106', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('420', '总金额：', '107', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('421', '总金额：', '116', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('422', '总金额：', '117', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('423', '总金额：', '118', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('424', '总金额：', '53', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('425', '总金额：', '87', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('426', '总金额：', '49', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('427', '总金额：', '50', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('428', '金额：', '28', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('429', '总金额：', '51', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('430', '总金额：', '122', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('431', '总金额：', '123', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('432', '总金额：', '124', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('433', '总金额：', '126', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('434', '总金额：', '114', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('435', '状态', '139', '', '', 'select', '', '2', ' | ,在库|在库,在途|在途,VDV|VDC', 'require', 'Flow', '0', ''), ('436', '库龄(天)', '139', '', '', 'number', '天', '2', '天', 'require', 'Flow', '0', ''), ('437', '车系', '139', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('438', '型号', '139', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('439', '颜色', '139', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('440', '内饰', '139', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('441', '底盘号(后六位)', '139', '', '', 'text', '后六位', '2', '后六位', 'require', 'Flow', '0', ''), ('442', '加装组件及价格', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('443', '零利点位%', '139', '', '', 'number', '％', '2', '％', 'require', 'Flow', '0', ''), ('444', '市场行情点位%', '139', '', '', 'number', '％', '2', '％', 'require', 'Flow', '0', ''), ('445', '周准价点位%', '139', '', '', 'number', '％', '2', '％', 'require', 'Flow', '0', ''), ('446', '优惠点率%', '139', '', '', 'number', '％', '2', '％', 'require', 'Flow', '0', ''), ('447', '现金优惠(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('448', '开票金额(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('449', '合同销售价格(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('450', '金融服务费(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('451', '精品金额(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('452', '保险金额(元)', '139', '', '', 'number', '元', '2', '元', 'require', 'Flow', '0', ''), ('453', '延伸业务综合毛利(元)', '139', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('454', '综合毛利(元)', '139', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('455', '定金(元)', '139', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('456', '辖区(省内/省外)', '139', '', '', 'select', '（省内／省外）', '2', ' | ,省内|省内,省外|省外', 'require', 'Flow', '0', ''), ('457', '是否是签约二网', '139', '', '', 'select', '（是／否）', '2', ' | ,是|是,否|否', 'require', 'Flow', '0', ''), ('458', '经销商名称', '139', '', '', 'text', '', '2', '', 'require', 'Flow', '0', ''), ('459', '经销商电话', '139', '', '', 'number', '', '2', '', 'require', 'Flow', '0', ''), ('462', 'name', '0', 'sort', 'msg', 'type', 'unit', 'layout', 'data', 'validate', 'controller', '0', 'config'), ('675', '时间:', '141', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('676', '时间:', '142', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('677', '时间:', '143', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('678', '时间:', '145', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('679', '开始时间:', '158', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('680', '开始时间:', '159', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('681', '开始时间:', '160', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('682', '开始时间:', '161', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('683', '开始时间:', '162', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('684', '开始时间:', '163', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('685', '开始时间:', '152', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('686', '开始时间:', '153', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('687', '开始时间:', '154', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('688', '开始时间:', '155', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('689', '开始时间:', '156', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('690', '开始时间:', '157', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('691', '开始时间:', '164', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('692', '结束时间:', '164', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('693', '开始时间:', '165', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('694', '结束时间:', '165', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('695', '开始时间:', '166', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('696', '结束时间:', '166', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('697', '开始时间:', '167', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('698', '结束时间:', '167', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('699', '开始时间:', '168', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('700', '结束时间:', '168', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('701', '开始时间:', '169', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('702', '结束时间:', '169', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('703', '开始时间:', '170', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('704', '结束时间:', '170', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('705', '开始时间:', '171', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('706', '结束时间:', '171', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('707', '开始时间:', '172', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('708', '结束时间:', '172', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('709', '开始时间:', '146', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('710', '开始时间:', '147', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('711', '开始时间:', '148', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('712', '结束时间:', '148', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('713', '开始时间:', '149', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('714', '结束时间:', '149', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('715', '开始时间:', '151', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('716', '结束时间:', '151', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('717', '开始时间:', '173', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('718', '结束时间:', '173', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('719', '开始时间:', '174', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('720', '结束时间:', '174', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('721', '开始时间:', '175', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('722', '结束时间:', '175', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('723', '开始时间:', '176', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('724', '结束时间:', '176', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('725', '开始时间:', '177', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('726', '结束时间:', '177', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('727', '开始时间:', '178', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('728', '结束时间:', '178', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('729', '开始时间:', '179', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('730', '结束时间:', '179', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('731', '开始时间:', '180', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('732', '结束时间:', '180', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('733', '开始时间:', '181', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('734', '结束时间:', '181', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('735', '时间:', '144', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('736', '时间:', '140', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('737', '结束时间:', '146', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('738', '结束时间:', '147', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('739', '开始时间:', '150', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('740', '结束时间:', '150', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('741', '结束时间:', '155', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('742', '结束时间:', '152', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('743', '结束时间:', '153', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('744', '结束时间:', '154', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('745', '结束时间:', '156', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('746', '结束时间:', '157', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('747', '结束时间:', '158', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('748', '结束时间:', '159', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('749', '结束时间:', '160', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('750', '结束时间:', '161', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('751', '结束时间:', '162', '2', '', 'datetime', '', '2', '', '', 'Flow', '0', ''), ('752', '结束时间:', '163', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('754', '请假类型:', '164', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('755', '请假类型:', '165', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('756', '请假类型:', '166', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('757', '请假类型:', '167', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('758', '请假类型:', '168', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('759', '请假类型:', '169', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('760', '请假类型:', '170', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('761', '请假类型:', '171', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('762', '请假类型:', '172', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('763', '时间:', '183', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('764', '开始时间:', '184', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('765', '结束时间:', '184', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('766', '开始时间:', '185', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('767', '结束时间:', '185', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('768', '开始时间:', '186', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('769', '结束时间:', '186', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('770', '开始时间:', '187', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('771', '结束时间:', '187', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('772', '请假类型:', '187', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('773', '开始时间:', '188', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('774', '结束时间:', '188', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('775', '请假类型:', '188', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('776', '开始时间:', '189', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('777', '结束时间:', '189', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('778', '开始时间:', '190', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('779', '结束时间:', '190', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('780', '时间:', '191', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('781', '开始时间:', '192', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('782', '结束时间:', '192', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('783', '开始时间:', '193', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('784', '结束时间:', '193', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('785', '开始时间:', '194', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('786', '结束时间:', '194', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('787', '开始时间:', '195', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('788', '结束时间:', '195', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('789', '请假类型:', '195', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('790', '开始时间:', '196', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('791', '结束时间:', '196', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('792', '请假类型:', '196', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('793', '开始时间:', '197', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('794', '结束时间:', '197', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('795', '开始时间:', '198', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('796', '结束时间:', '198', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('797', '时间:', '199', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('798', '开始时间:', '200', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('799', '结束时间:', '200', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('800', '开始时间:', '201', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('801', '结束时间:', '201', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('802', '开始时间:', '202', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('803', '结束时间:', '202', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('804', '开始时间:', '203', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('805', '结束时间:', '203', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('806', '请假类型:', '203', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('807', '开始时间:', '204', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('808', '结束时间:', '204', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('809', '请假类型:', '204', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('810', '开始时间:', '205', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('811', '结束时间:', '205', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('812', '开始时间:', '206', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('813', '结束时间:', '206', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('814', '提示', '158', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('815', '提示', '159', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('816', '提示', '160', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('817', '提示', '142', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('818', '提示', '161', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('819', '提示', '162', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('820', '提示', '186', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('821', '提示', '194', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('822', '提示', '202', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('823', '提示', '152', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('824', '提示', '153', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('825', '提示', '154', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('826', '提示', '155', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('827', '提示', '156', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('829', '提示', '157', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('830', '提示', '185', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('831', '提示', '193', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('832', '提示', '201', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('833', '提示', '163', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('835', '班次：', '158', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('836', '班次', '159', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('837', '班次', '160', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('838', '班次', '162', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('839', '班次：', '163', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('840', '班次', '161', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('842', '班次', '186', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('843', '班次', '202', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('844', '班次：', '194', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('845', '时间:', '207', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('846', '开始时间:', '208', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('847', '结束时间:', '208', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('848', '开始时间:', '209', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('849', '结束时间:', '209', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('850', '开始时间:', '210', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('851', '结束时间:', '210', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('852', '开始时间:', '211', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('853', '结束时间:', '211', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('854', '请假类型:', '211', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('855', '开始时间:', '212', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('856', '结束时间:', '212', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('857', '请假类型:', '212', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('858', '开始时间:', '213', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('859', '结束时间:', '213', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('860', '开始时间:', '214', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('861', '结束时间:', '214', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('862', '提示', '210', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('863', '提示', '209', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('864', '班次', '210', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('894', '时间:', '215', '', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('895', '开始时间:', '216', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('896', '结束时间:', '216', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('897', '开始时间:', '217', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('898', '结束时间:', '217', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('899', '开始时间:', '218', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('900', '结束时间:', '218', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('901', '开始时间:', '219', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('902', '结束时间:', '219', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('903', '请假类型:', '219', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('904', '开始时间:', '220', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('905', '结束时间:', '220', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('906', '请假类型:', '220', '9', '', 'select', '', '2', '病假|病假,产假|产假,婚假|婚假,丧假|丧假,事假|事假,其它假期|其它假期', '', 'Flow', '0', ''), ('907', '开始时间:', '221', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('908', '结束时间:', '221', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('909', '开始时间:', '222', '1', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('910', '结束时间:', '222', '2', '', 'datetime', '', '2', '', 'require', 'Flow', '0', ''), ('911', '提示', '218', '3', '', 'help', '', '2', '*每次加班只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('912', '提示', '217', '3', '', 'help', '', '2', '*每次调休只能选一天，多选时间无效，系统默认一天  。 *请勿重复提单。', '', 'Flow', '0', ''), ('913', '班次：', '218', '4', '', 'schedual', '', '2', '', 'require', 'Flow', '0', ''), ('914', '提醒', '223', '', '', 'help', '', '3', '温馨提示：售后部专用，其他部门请勿代填。', 'require', 'Flow', '0', ''), ('915', '提示', '224', '', '', 'help', '', '3', '适用范围： 1. 店面备件的外销、批发（不含备件的正常零售）。 2. 4S店之间的备件换货。 3.  呆滞货、超期库存(即一年以上库龄备件)的处理，含外销，核销，折扣零售等。 4. 备件盘点后报废、核销。 5.  其他备件减值事项。备注：备件用于店内维修车辆销售不在此规定范围。', '', 'Flow', '0', ''), ('916', '总数量', '224', '', '', 'number', '', '2', '', 'require', 'Flow', '0', ''), ('917', '总金额', '224', '', '', 'number', '元', '2', '', 'require', 'Flow', '0', ''), ('918', '提示2', '224', '', '', 'help', '', '3', '温馨提示：售后备件部人员专用！', '', 'Flow', '0', '');
INSERT INTO `think_rank` VALUES ('1', 'RG40', '部长', '1', '0'), ('2', 'RG30', '科长', '2', '0'), ('3', 'RG20', '主管', '3', '0'), ('4', 'RG10', '助理', '4', '0'), ('5', 'RG00', '总经理', '0', '0');

-- ----------------------------
--  Procedure structure for `userinfo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `userinfo`;
delimiter ;;
CREATE DEFINER=`root`@`%` PROCEDURE `userinfo`(IN uname varchar(20))
BEGIN
SELECT * FROM think_user u WHERE u.name=uname;
END
 ;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
