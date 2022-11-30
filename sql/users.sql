-- auth_api.users definition

CREATE TABLE `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `email` varchar(319) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` varchar(10) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;