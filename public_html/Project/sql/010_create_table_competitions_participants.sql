CREATE Table if NOT exists `CompetitionParticipants`(
  `id` INT AUTO_INCREMENT,
  `comp_id` INT,
  `user_id` INT,
  `created` TIMESTAMP default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`comp_id`) REFERENCES Competitions(`id`),
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
  UNIQUE KEY (`comp_id`, `user_id`)
)