-- 创建库
CREATE
    DATABASE `teammail` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;

-- 用户表
CREATE TABLE `tm_admins`
(
    `id`         bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `mobile`     char(11)        NOT NULL DEFAULT '' COMMENT '手机',
    `email`      varchar(128)    NOT NULL DEFAULT '' COMMENT '邮箱',
    `password`   varchar(255)    NOT NULL DEFAULT '' COMMENT '密码',
    `remark`     text COMMENT '备注',
    `created_at` datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_name (`name`),
    INDEX idx_email (`email`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='用户表';

-- 租户表
CREATE TABLE `mt_tenants`
(
    `id`            bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`          varchar(128)    NOT NULL DEFAULT '' COMMENT '名称',
    `firstname`     varchar(64)     NOT NULL DEFAULT '' COMMENT '姓',
    `lastname`      varchar(64)     NOT NULL DEFAULT '' COMMENT '名',
    `nickname`      varchar(64)     NOT NULL DEFAULT '' COMMENT '昵称',
    `type`          int UNSIGNED    NOT NULL DEFAULT 0 COMMENT '类型:1=人个,2=企业',
    `email`         varchar(128)    NOT NULL DEFAULT '' COMMENT '邮箱',
    `mobile_prefix` varchar(128)    NOT NULL DEFAULT '' COMMENT '前缀',
    `mobile`        varchar(128)    NOT NULL DEFAULT '' COMMENT '电话',
    `expiration_at` datetime        NULL     DEFAULT NULL COMMENT '过期时间',
    `remark`        text COMMENT '说明',
    `created_at`    datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`    datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`    datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='租户表';

-- 用户表
CREATE TABLE `mt_users`
(
    `id`         bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `tenant_id`  bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属租户',
    `name`       varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `mobile`     char(11)        NOT NULL DEFAULT '' COMMENT '手机',
    `email`      varchar(128)    NOT NULL DEFAULT '' COMMENT '邮箱',
    `password`   varchar(255)    NOT NULL DEFAULT '' COMMENT '密码',
    `remark`     text COMMENT '备注',
    `created_at` datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='用户表';

-- 客户表
CREATE TABLE `tm_customers`
(
    `id`            int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `enterprise_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属企业',
    `nickname`      varchar(128) NOT NULL DEFAULT '' COMMENT '客户昵称',
    `name`          varchar(128) NOT NULL DEFAULT '' COMMENT '实际姓名',
    `firstname`     varchar(64)  NOT NULL DEFAULT '' COMMENT '姓',
    `lastname`      varchar(64)  NOT NULL DEFAULT '' COMMENT '名',
    `email`         varchar(64)  NOT NULL DEFAULT '' COMMENT '客户邮箱',
    `remark`        text COMMENT '备注',
    `created_at`    datetime     NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`    datetime     NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`    datetime     NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_email (`email`) COMMENT '邮箱'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='客户表';


-- 邮件表
CREATE TABLE `tm_mails`
(
    `id`               int UNSIGNED     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `tenant_id`        int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属企业',
    `email_config_id`  int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属邮件配置',
    `customer_id`      int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属客户',
    `reply_user_id`    int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属回复用户',
    `uid`              int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '邮箱UID',
    `message_id`       varchar(128)     NOT NULL DEFAULT '' COMMENT '邮件标题',
    `folder_name`      varchar(64)      NOT NULL DEFAULT '' COMMENT '文件夹',
    `msglist`          int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '消息ID',
    `subject`          varchar(1000)    NOT NULL DEFAULT '' COMMENT '邮件标题',
    `body`             longtext COMMENT '邮件内容',
    `from`             text COMMENT '发件人',
    `to`               text COMMENT '收件人',
    `cc`               text COMMENT '抄送人',
    `bcc`              text COMMENT '密送人',
    `reply_to`         text COMMENT '回复人',
    `sender`           text COMMENT '发件人',
    `references`       mediumtext COMMENT '引用',
    `in_reply_to`      text COMMENT '回复',
    `sum_total`        tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '发送次数',
    `attachment_count` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '邮件附件数',
    `send_status`      tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '发送状态:0=未知,1=待发送,2=发送中,3=已发送,4=发送失败,5=发送异常',
    `read_switch`      tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读状态',
    `remark`           text COMMENT '备注',
    `send_at`          datetime         NULL     DEFAULT NULL COMMENT '发送时间',
    `created_at`       datetime         NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`       datetime         NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`       datetime         NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_tenant_id (`tenant_id`) COMMENT '企业普通索引',
    INDEX idx_uid (`uid`) COMMENT '邮箱UID',
    INDEX idx_message_id (`message_id`) COMMENT '邮箱消息ID'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci COMMENT ='邮件表';

-- 邮件用户关联表
CREATE TABLE `tm_mail_account_relations`
(
    `id`              int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `mail_id`         int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属邮件',
    `mail_account_id` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属邮件用户',
    `created_at`      datetime     NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`      datetime     NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`      datetime     NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='邮件用户关联表';

-- 邮件用户表
CREATE TABLE `tm_mail_accounts`
(
    `id`         int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `tenant_id`  int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属企业',
    `mail`       varchar(192) NOT NULL DEFAULT '' COMMENT '邮件',
    `personal`   varchar(64)  NOT NULL DEFAULT '' COMMENT '个人名称',
    `mailbox`    varchar(64)  NOT NULL DEFAULT '' COMMENT '邮箱',
    `host`       varchar(128) NOT NULL DEFAULT '' COMMENT '域名',
    `full`       varchar(255) NOT NULL DEFAULT '' COMMENT '全称',
    `created_at` datetime     NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime     NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime     NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_tenant_id (`tenant_id`) COMMENT '企业普通索引'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='邮件用户表';

-- 邮箱附件
CREATE TABLE `tm_mail_attachments`
(
    `id`         int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `tenant_id`  int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属企业',
    `mail_id`    int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属邮件',
    `file_id`    int UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属文件',
    `msg_id`     varchar(128) NOT NULL DEFAULT '' COMMENT '消息ID',
    `remark`     text COMMENT '备注',
    `created_at` datetime     NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime     NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at` datetime     NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_tenant_id (`tenant_id`) COMMENT '企业普通索引',
    INDEX idx_mail_id (`mail_id`, `file_id`) COMMENT '邮件和文件'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='邮件附件表';

-- 文件表
CREATE TABLE `tm_files`
(
    `id`            bigint UNSIGNED  NOT NULL AUTO_INCREMENT COMMENT '主键',
    `original_name` varchar(255)     NOT NULL DEFAULT '' COMMENT '原文件名称',
    `storage_name`  varchar(255)     NOT NULL DEFAULT '' COMMENT '存储名称',
    `ext`           varchar(32)      NOT NULL DEFAULT '' COMMENT '文件扩展名',
    `mime`          varchar(255)     NOT NULL DEFAULT '' COMMENT '文件类型名',
    `hash`          varchar(255)     NOT NULL DEFAULT '' COMMENT '文件哈希值',
    `size`          int UNSIGNED     NOT NULL COMMENT '文件大小',
    `source`        tinyint UNSIGNED NOT NULL COMMENT '文件来源',
    `created_at`    datetime         NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`    datetime         NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`    datetime         NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='文件表';


-- 历史记录表
CREATE TABLE `tm_history_records`
(
    `id`                   int UNSIGNED     NOT NULL AUTO_INCREMENT COMMENT '主键',
    `tenant_id`            int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属企业',
    `parent_id`            int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '所属父类',
    `record_object_id`     int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '记录对象',
    `event_type`           tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '事件类型:1=create,2=update,3=delete',
    `record_name`          varchar(32)      NOT NULL DEFAULT '' COMMENT '记录名称',
    `record_type`          tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '数据类型:1=number,2=string,3=array,4=object',
    `record_key`           varchar(255)     NOT NULL DEFAULT '' COMMENT '元数据键',
    `record_current_value` text COMMENT '当前数据值',
    `record_origin_value`  text COMMENT '原始数据值',
    `title`                varchar(128)     NOT NULL DEFAULT '' COMMENT '标题',
    `description`          varchar(255)     NOT NULL DEFAULT '' COMMENT '说明',
    `remark`               text COMMENT '备注',
    `created_at`           datetime         NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`           datetime         NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`           datetime         NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='历史记录表';
