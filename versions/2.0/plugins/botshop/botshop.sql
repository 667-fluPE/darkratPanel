DROP TABLE IF EXISTS botshop_access;
DROP TABLE IF EXISTS botshop_orders;

CREATE TABLE `botshop_access` (
  `id` int(11) NOT NULL,
  `created_by_userid` int(255) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `botprice` varchar(255) NOT NULL,
  `sandbox` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes für die Tabelle `botshop_access`
--
ALTER TABLE `botshop_access`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `botshop_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- Tabellenstruktur für Tabelle `botshop_orders`
--
CREATE TABLE `botshop_orders` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `privatekey` varchar(255) DEFAULT NULL,
  `botamount` varchar(255) DEFAULT NULL,
  `loadurl` varchar(255) DEFAULT NULL,
  `coinstopay` varchar(255) DEFAULT NULL,
  `usd` varchar(255) DEFAULT NULL,
  `somesigfromkey` mediumtext,
  `userauthkey` varchar(255) DEFAULT NULL,
  `from_access_api` varchar(255) DEFAULT NULL,
  `payed` int(11) NOT NULL DEFAULT '0',
  `taskid` varchar(255) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Indizes für die Tabelle `botshop_orders`
--
ALTER TABLE `botshop_orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `botshop_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
