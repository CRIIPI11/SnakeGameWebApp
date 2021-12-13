CREATE Table if NOT Exists `PointsHistory` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` int,
  `point_change` int,
  `reason` VARCHAR(20) NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`)
)