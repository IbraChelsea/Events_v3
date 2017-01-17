-- db migrations v3

ALTER TABLE `event` ADD `title` VARCHAR(250) NOT NULL AFTER `code`;
