SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bildverwaltung`
--
CREATE DATABASE IF NOT EXISTS `bildverwaltung` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `bildverwaltung`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`username`);

-- --------------------------------------------------------

--
-- Admin User in die Tabelle `users` einfügen
-- Passwort = 12345
--

-- INSERT INTO `users` (`username`, `vorname`, `nachname`, `email`, `password`, `is_admin`) 
-- VALUES ("admin", "adminVorname", "adminNachname", "adminEmail", "$2y$10$RxG6taFmPvxRcTuHuOJo/.aiwiLz71Ph1xgwDKPmyNKWx7Lt8NIF.", 1);


--
-- Tabellenstruktur für Tabelle `messages`
--
/*
CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL,
  `messagetext` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--
/*
CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `passwort` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `communication`
--
/*
ALTER TABLE `communication`
  ADD PRIMARY KEY (`commid`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `communication`
--
ALTER TABLE `communication`
  MODIFY `commid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

*/

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
