/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : contact_book

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-09-16 16:48:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `moblie_number` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `landline_number` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `user_id` int(22) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES ('29', 'dfgdf', 'dfgdfg', 'dfgfdgdfg', '3443245555', '1474110429.jpg', '3242355', 're@grr.la', 'dfgdfgdfg', '1');
INSERT INTO `contacts` VALUES ('30', 'sadasd', '', 'sadasdas', '1111111111', '1474110442.jpg', '1111111', '', 'sadasdsdsda', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(22) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` text,
  `password_hash` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `profile_pic_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'dineshghule321@gmail.com', 'Dinesh', 'Ghule', 'Akole', '6699b3e7d90ca4cbc75d58c3691c4ad5', 'F2Onp0cG80yM49UeGg8NO65TJaBzvUiaX7y', '2017-09-15 11:09:49', null, '1');
SET FOREIGN_KEY_CHECKS=1;
