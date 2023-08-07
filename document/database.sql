-- 创建库
CREATE DATABASE medical_treatment_input_system DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;

-- 用户表
CREATE TABLE `mt_users`
(
    `id`         bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `email`      varchar(128)    NOT NULL DEFAULT '' COMMENT '邮箱',
    `password`   varchar(255)    NOT NULL DEFAULT '' COMMENT '密码',
    `mobile`     char(11)        NOT NULL DEFAULT '' COMMENT '手机',
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

-- 系统表
CREATE TABLE `mt_systems`
(
    `id`          bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`        varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `type`        int UNSIGNED    NOT NULL DEFAULT 0 COMMENT '类型:1=录入,2=建档,3=爬取',
    `description` text COMMENT '说明',
    `created_at`  datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`  datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`  datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='系统表';

-- 系统表头
CREATE TABLE `mt_system_headers`
(
    `id`            bigint UNSIGNED  NOT NULL AUTO_INCREMENT COMMENT '主键',
    `system_id`     bigint UNSIGNED  NOT NULL DEFAULT 0 COMMENT '所属系统',
    `header_key`    varchar(32)      NOT NULL DEFAULT '' COMMENT '键',
    `header_val`    varchar(64)      NOT NULL DEFAULT '' COMMENT '值',
    `status`        tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '显示状态: 0=禁用,1=启用',
    `unique_column` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '唯一列: 0=否,1=是',
    `sort`          int UNSIGNED     NOT NULL DEFAULT 0 COMMENT '排序',
    `created_at`    datetime         NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`    datetime         NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`    datetime         NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='系统表头';

-- INSERT INTO `mt_system_headers`(`system_id`, `header_key`, `header_val`) VALUES (1, 'MD5ABC', '姓名');
-- INSERT INTO `mt_system_headers`(`system_id`, `header_key`, `header_val`) VALUES (1, 'MD5ABC', '身份证');
-- INSERT INTO `mt_system_headers`(`system_id`, `header_key`, `header_val`) VALUES (1, 'MD5ABC', '村（居）委会');

-- 系统社区关联表
# CREATE TABLE `mt_system_community_relations`
# (
#     `id`           bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
#     `system_id`    bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属系统',
#     `community_id` bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属社区',
#     PRIMARY KEY (`id`) COMMENT '主键'
# ) ENGINE = InnoDB
#   DEFAULT CHARSET = utf8mb4
#   COLLATE = utf8mb4_general_ci COMMENT ='系统社区关联表';

-- 社区表
CREATE TABLE `mt_communities`
(
    `id`          bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `system_id`   bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属系统',
    `name`        varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `description` text COMMENT '说明',
    `created_at`  datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`  datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`  datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_name (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='社区表';

-- 活动表
CREATE TABLE `mt_activities`
(
    `id`             bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `system_id`      bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属系统',
    `communities_id` bigint UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属社区',
    `name`           varchar(64)     NOT NULL DEFAULT '' COMMENT '名称',
    `description`    text COMMENT '说明',
    `created_at`     datetime        NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`     datetime        NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`     datetime        NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键',
    INDEX idx_name (`name`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='活动表';

-- 文件表
CREATE TABLE `mt_files`
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

-- 活动数据表
CREATE TABLE `mt_activity_sheets`
(
    `id`             bigint UNSIGNED  NOT NULL AUTO_INCREMENT COMMENT '主键',
    `system_id`      bigint UNSIGNED  NOT NULL DEFAULT 0 COMMENT '所属系统',
    `communities_id` bigint UNSIGNED  NOT NULL DEFAULT 0 COMMENT '所属社区',
    `activities_id`  bigint UNSIGNED  NOT NULL DEFAULT 0 COMMENT '所属活动',
    `unique_name`    varchar(32)      NOT NULL DEFAULT '' COMMENT '唯一名称',
    `unique_value`   varchar(255)     NOT NULL DEFAULT '' COMMENT '唯一列值',
    `datahash`       varchar(64)      NOT NULL DEFAULT '' COMMENT '数据哈希',
    `datarow`        longtext COMMENT '数据行',
    `sync_status`    tinyint UNSIGNED NOT NULL COMMENT '同步状态',
    `created_at`     datetime         NULL     DEFAULT NULL COMMENT '创建时间',
    `updated_at`     datetime         NULL     DEFAULT NULL COMMENT '更新时间',
    `deleted_at`     datetime         NULL     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) COMMENT '主键'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci COMMENT ='活动数据表';

-- php artisan make:model ActivitySheets --all
