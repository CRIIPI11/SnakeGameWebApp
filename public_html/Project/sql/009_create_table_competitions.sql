CREATE Table if NOT exists `Competitions`(
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `duration` int DEFAULT 5,
  `expires` TIMESTAMP default (
    DATE_ADD(CURRENT_TIMESTAMP, INTERVAL (`duration`) DAY)
  ),
  `current_reward` int DEFAULT (`starting_reward`),
  `starting_reward` int DEFAULT 1,
  `join_fee` int DEFAULT 1,
  `current_participants` int DEFAULT 0,
  `min_participants` int DEFAULT 4,
  `paid_out` TINYINT(1) DEFAULT 0,
  `min_score` int DEFAULT 1,
  `first_place_per` int DEFAULT 70,
  `second_place_per` int DEFAULT 20,
  `third_place_per` INT DEFAULT 10,
  `cost_to_create` int DEFAULT 1,
  `created` TIMESTAMP default CURRENT_TIMESTAMP,
  `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  check (min_score >= 1),
  check (starting_reward >= 1),
  check (current_reward >= starting_reward),
  check (min_participants >= 3),
  check (current_participants >= 0),
  check(join_fee >= 0),
  check(
    first_place_per + second_place_per + third_place_per = 100
  ) PRIMARY KEY (`id`)
)