DROP TABLE IF EXISTS ddos_avalible;
DROP TABLE IF EXISTS ddos_tasks;

CREATE TABLE `ddos_avalible` (
  `id` int(11) NOT NULL,
  `botid` varchar(255) NOT NULL,
  `lastseen` varchar(255) NOT NULL,
  `ddos_taskid` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `ddos_tasks` (
  `id` int(11) NOT NULL,
  `maxtime` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `targetip` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `ddos_tasks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ddos_avalible`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ddos_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `ddos_avalible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;