-- ---
-- Table 'Role'
-- Table for Domain''s Information
-- ---

DROP TABLE IF EXISTS `role`;
		
CREATE TABLE `role` (
  `id` INTEGER AUTO_INCREMENT ,
  `name` VARCHAR(60) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) COMMENT 'Table for Role''s Information';
-- ---
-- Table 'group'
-- Table for group''s information
-- ---

DROP TABLE IF EXISTS `group`;
		
CREATE TABLE `group` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `domain_id` INTEGER NOT NULL,
  `parent_group_id` INTEGER NULL DEFAULT NULL,
  `name` VARCHAR(60) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) COMMENT 'Table for group''s information';

-- ---
-- Table 'Role_User_Group'
-- 
-- ---

DROP TABLE IF EXISTS `group_user_role`;
		
CREATE TABLE `group_user_role` (
  `id` INTEGER AUTO_INCREMENT,
  `group_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL,
  `role_id` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'affiliate'
-- 
-- ---

DROP TABLE IF EXISTS `affiliate`;
		
CREATE TABLE `affiliate` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `group_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL,
  `approved` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'user'
-- 
-- ---

DROP TABLE IF EXISTS `user`;
		
CREATE TABLE `user` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `employee_id` INTEGER NOT NULL,
  `names` VARCHAR(140) NOT NULL,
  `lastnames` VARCHAR(140) NOT NULL,
  `mail` VARCHAR(100) NOT NULL,
  `username` VARCHAR(60) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `is_visitor` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'note'
-- 
-- ---

DROP TABLE IF EXISTS `note`;
		
CREATE TABLE `note` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `user_id` INTEGER NOT NULL,
  `title` VARCHAR(140) NOT NULL,
  `source_id` INTEGER NOT NULL,
  `summary` VARCHAR(256) NOT NULL,
  `agreement_type_id` INTEGER NOT NULL,
  `init_date` DATE NULL DEFAULT NULL,
  `finish_date` DATE NULL DEFAULT NULL,
  `status_id` INTEGER NOT NULL,
  `date_approved` DATE NULL DEFAULT NULL,
  `performer_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);
-- ---
-- Table 'source'
-- 
-- ---

DROP TABLE IF EXISTS `source`;
		
CREATE TABLE `source` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `title` VARCHAR(60) NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'status'
-- 
-- ---

DROP TABLE IF EXISTS `status`;
		
CREATE TABLE `status` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `name` VARCHAR(60) NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'note_type'
-- 
-- ---

DROP TABLE IF EXISTS `note_type`;
		
CREATE TABLE `note_type` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `name` VARCHAR(60) NOT NULL,
  `description` VARCHAR(140) NOT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'note_approver'
-- 
-- ---

DROP TABLE IF EXISTS `note_approver`;
		
CREATE TABLE `note_approver` (
  `id` INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
  `note_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL,
  `choice` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`)
);
