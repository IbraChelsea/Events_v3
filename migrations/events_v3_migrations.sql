-- db migrations v3

ALTER TABLE `event` ADD `title` VARCHAR(250) NOT NULL AFTER `code`;
ALTER TABLE `event` ADD `subtitle` VARCHAR(255) NOT NULL AFTER `title`;
ALTER TABLE `event` ADD `beschreibung` VARCHAR(512) NOT NULL AFTER `subtitle`;
ALTER TABLE `event` ADD `tipp` VARCHAR(300) NOT NULL AFTER `beschreibung`;
ALTER TABLE `event` ADD `treffpunk` VARCHAR(255) NOT NULL AFTER `tipp`;
ALTER TABLE `event` ADD `email Betreff` VARCHAR(50) NOT NULL AFTER `eventgroupcode`;
ALTER TABLE `event` ADD `email Inhalt` TEXT NOT NULL AFTER `email Betreff`;
ALTER TABLE `event` ADD `land` VARCHAR(15) NOT NULL AFTER `email Inhalt`;
ALTER TABLE `event` ADD `mindestalter` TINYINT(2) NOT NULL AFTER `land`;
ALTER TABLE `event` ADD `höchstalter` TINYINT(2) NOT NULL AFTER `mindestalter`;
ALTER TABLE `event` ADD `überbuchung` BOOLEAN NOT NULL AFTER `höchstalter`;
ALTER TABLE `event` ADD `tn-liste` TEXT NOT NULL AFTER `überbuchung`;
ALTER TABLE `event` ADD `erstellt am` DATE NOT NULL AFTER `tn-liste`;
ALTER TABLE `event` ADD `aktualisiert am` DATE NOT NULL AFTER `erstellt am`;
ALTER TABLE `event` ADD `sprache` VARCHAR(15) NOT NULL AFTER `aktualisiert am`;
ALTER TABLE `event` ADD `kontaktinformationen` TEXT NOT NULL AFTER `sprache`;
ALTER TABLE `event` ADD `wartlistencode` VARCHAR(30) NOT NULL AFTER `kontaktinformationen`;
ALTER TABLE `event` ADD `layout` VARCHAR(10) NOT NULL AFTER `wartlistencode`;

layout???
wartlistencode??
email form??? nicht erstellt