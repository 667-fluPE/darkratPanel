DROP TABLE IF EXISTS private_messages;


CREATE TABLE `private_messages` (
  `id` int(11) NOT NULL,
  `from_userid` varchar(255) NOT NULL,
  `to_userid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `private_messages`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `private_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

