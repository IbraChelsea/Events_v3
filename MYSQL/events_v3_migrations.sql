-- db migrations v3

ALTER TABLE `event` ADD `title` VARCHAR(250) NOT NULL AFTER `code`;
ALTER TABLE `event` ADD `Subtitle` VARCHAR(255) NOT NULL AFTER `title`;
ALTER TABLE `event` ADD `Beschreibung` VARCHAR(512) NOT NULL AFTER `Subtitle`;
ALTER TABLE `event` ADD `Tipp` VARCHAR(300) NOT NULL AFTER `Beschreibung`;
ALTER TABLE `event` ADD `Treffpunk` VARCHAR(255) NOT NULL AFTER `Tipp`;
ALTER TABLE `event` ADD `Email Betreff` VARCHAR(50) NOT NULL AFTER `eventgroupcode`;
ALTER TABLE `event` ADD `Email Inhalt` TEXT NOT NULL AFTER `Email Betreff`;
ALTER TABLE `event` ADD `Land` VARCHAR(15) NOT NULL AFTER `Email Inhalt`;
ALTER TABLE `event` ADD `Mindestalter` TINYINT(2) NOT NULL AFTER `Land`;
ALTER TABLE `event` ADD `Höchstalter` TINYINT(2) NOT NULL AFTER `Mindestalter`;
ALTER TABLE `event` ADD `Überbuchung` BOOLEAN NOT NULL AFTER `Höchstalter`;
ALTER TABLE `event` ADD `TN-Liste` TEXT NOT NULL AFTER `Überbuchung`;
ALTER TABLE `event` ADD `erstellt am` DATE NOT NULL AFTER `TN-Liste`;
ALTER TABLE `event` ADD `aktualisiert am` DATE NOT NULL AFTER `erstellt am`;
ALTER TABLE `event` ADD `Sprache` VARCHAR(15) NOT NULL AFTER `aktualisiert am`;
ALTER TABLE `event` ADD `Kontaktinformationen` TEXT NOT NULL AFTER `Sprache`;
ALTER TABLE `event` ADD `wartlistencode` VARCHAR(30) NOT NULL AFTER `Kontaktinformationen`;
ALTER TABLE `event` ADD `layout` VARCHAR(10) NOT NULL AFTER `wartlistencode`;

layout???
wartlistencode??
email form??? nicht erstellt