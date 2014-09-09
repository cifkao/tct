RENAME TABLE `scorings` TO `scorings_backup`;
CREATE TABLE `scorings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translation_id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL,
  `result` float DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `scorings` (`translation_id`, `hash`, `user_hash`, `result`, `created`) SELECT `translation_b_id`, `hash`, `user_hash`, 1, `created` FROM `scorings_backup` WHERE `result` = 'b';
INSERT INTO `scorings` (`translation_id`, `hash`, `user_hash`, `result`, `created`) SELECT `translation_a_id`, `hash`, `user_hash`, 1, `created` FROM `scorings_backup` WHERE `result` = 'a';


