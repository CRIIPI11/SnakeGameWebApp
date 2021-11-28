CREATE TABLE if NOT EXISTS `Scores` (
  `id` int not null auto_increment,
  `user_id` int,
  `score` int,
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES Users(`id`),
  check (score > 0)
)