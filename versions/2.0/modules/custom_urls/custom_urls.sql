
DROP TABLE IF EXISTS routes;

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `routes` (`id`, `controller`, `route`, `active`) VALUES
(1, 'Main@login', '/login', '1'),
(2, 'Main@index', '/dashboard', '1'),
(3, 'Main@tasks', '/tasks,/tasks/(\\d+)', '1'),
(4, 'Main@logout', '/logout', '1'),
(5, 'Main@settings', '/settings', '1'),
(6, 'Main@bots', '/bots', '1'),
(7, 'Main@taskdetails', '/taskdetails/(\\d+)', '1'),
(8, 'Main@edituser', '/edituser/(\\d+)', '1'),
(9, 'Main@botinfo', '/botinfo/(\\d+)', '1'),
(10, 'Main@request', '/request', '1');

ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
