
DROP TABLE IF EXISTS ppusers;

CREATE TABLE `ppusers` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `creditcard_id` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS pporders;

CREATE TABLE `pporders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) DEFAULT NULL,
  `payment_id` varchar(50) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `amount` varchar(20) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,  
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB;