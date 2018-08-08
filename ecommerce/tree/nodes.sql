/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50163
 Source Host           : localhost
 Source Database       : mydb

 Target Server Type    : MySQL
 Target Server Version : 50163
 File Encoding         : utf-8

 Date: 05/04/2014 09:09:45 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `nodes`
-- ----------------------------
DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `nodes`
-- ----------------------------
BEGIN;
INSERT INTO `nodes` VALUES ('1', '0', 'Node 1'), ('2', '0', 'Node 2'), ('3', '0', 'Node 3'), ('4', '0', 'Node 4'), ('5', '1', 'Node 1.1'), ('6', '1', 'Node 1.2'), ('7', '5', 'Node 1.1.1'), ('8', '5', 'Node 1.1.2'), ('9', '5', 'Node 1.1.3');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
