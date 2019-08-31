DROP TABLE IF EXISTS reverse_socks;

CREATE TABLE `reverse_socks` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `country_city` varchar(255) DEFAULT NULL,
    `lastcheck` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `reverse_socks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reverse_socks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
