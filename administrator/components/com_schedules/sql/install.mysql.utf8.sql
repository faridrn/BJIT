CREATE TABLE IF NOT EXISTS `#__schedules` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`state` TINYINT(1)  NOT NULL DEFAULT '1',
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`date` DATE NOT NULL DEFAULT '0000-00-00',
`occassion` VARCHAR(255)  NOT NULL ,
`programs` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

