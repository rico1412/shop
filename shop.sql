﻿drop database shop;
create database shop charset utf8;

use shop;

create table sp_goods_info (
  id int unsigned primary key auto_increment,
  name varchar(50) not null default '' comment '商品名称',
  intro varchar(255) not null default '' comment '商品简介',
  descript text comment '商品描述',
  price decimal(10, 2) not null default 0 comment '商品价格',
  category_id int unsigned not null default 1 comment '商品类别',
  is_collection tinyint unsigned not null default 0 comment '是否已收藏 0 未收藏 1 已收藏'
)charset utf8;

alter table sp_goods_info add img varchar(255) not null default '' comment '商品图片路径';

alter table sp_goods_info add add_time int unsigned not null default 0 comment '商品添加时间';

alter table sp_goods_info add status tinyint unsigned not null default 0 comment '商品状态 0 下架 1 上架';

alter table sp_goods_info add ori_price decimal(10, 2) not null default 0 comment '商品原价';

create table sp_category (
  id int unsigned primary key auto_increment,
  name varchar(30) not null default '' comment '分类名称',
  parent_id int unsigned not null default 0 comment '父分类id，0代表此分类为顶级分类'
)charset utf8;

create table sp_user (
  id int unsigned primary key auto_increment,
  acc varchar(50) not null default '' comment '用户账号',
  pwd varchar(32) not null default '' comment '用户密码',
  nickname varchar(50) not null default '' comment '用户昵称',
  is_admin tinyint unsigned not null default 0 comment '是否是管理员 0 不是 1 是',
  regtime int unsigned not null default 0 comment '注册时间',
  img varchar(255) not null default '' comment '用户头像'
)charset utf8;

create table sp_order (
  id int unsigned primary key auto_increment,
  order_id varchar(50) not null default '' comment '订单号',
  order_price decimal(10, 2) not null default 0 comment '订单金额',
  buyer_id int unsigned not null default 0 comment '买家id',
  buyer_nickname varchar(50) not null default '' comment '买家昵称',
  order_time int unsigned not null default 0 comment '下单时间',
  status tinyint unsigned not null default 0 comment '订单状态 0：未处理 1：已处理'
)charset utf8;

create table sp_order_detail (
  id int unsigned primary key auto_increment,
  p_id int unsigned not null default 0 comment '商品id',
  count int unsigned not null default 1 comment '购买数量',
  order_id varchar(50) not null default '' comment '订单号'
)charset utf8;