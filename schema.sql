-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `projectId` INT(11)      NOT NULL,
  `name`      VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projectId` (`projectId`)
);

-- --------------------------------------------------------

--
-- Table structure for table `event_hashes`
--

CREATE TABLE IF NOT EXISTS `event_hashes` (
  `id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `eventRecordId` INT(11)      NOT NULL,
  `hash`          VARCHAR(255) NOT NULL,
  `status`        INT(11)      NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`),
  KEY `eventRecordId` (`eventRecordId`)
);

-- --------------------------------------------------------

--
-- Table structure for table `event_records`
--

CREATE TABLE IF NOT EXISTS `event_records` (
  `id`      INT(11)      NOT NULL AUTO_INCREMENT,
  `eventId` INT(11)      NOT NULL,
  `mail`    VARCHAR(255) NOT NULL,
  `status`  INT(11)      NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eventId` (`eventId`)
);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `userId` INT(11)      NOT NULL,
  `name`   VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
);

-- --------------------------------------------------------

--
-- Table structure for table `group_mails`
--

CREATE TABLE IF NOT EXISTS `group_mails` (
  `id`      INT(11)      NOT NULL AUTO_INCREMENT,
  `groupId` INT(11)      NOT NULL,
  `mail`    VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`groupId`, `mail`),
  KEY `mail_index` (`mail`)
);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id`   INT(11) NOT NULL AUTO_INCREMENT,
  `userId` INT(11) NOT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

INSERT INTO `users` (username, password) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `projects` (`id`);

--
-- Constraints for table `event_hashes`
--
ALTER TABLE `event_hashes`
  ADD CONSTRAINT `event_hashes_ibfk_1` FOREIGN KEY (`eventRecordId`) REFERENCES `event_records` (`id`);

--
-- Constraints for table `event_records`
--
ALTER TABLE `event_records`
  ADD CONSTRAINT `event_records_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `group_mails`
--
ALTER TABLE `group_mails`
  ADD CONSTRAINT `group_mails_ibfk_1` FOREIGN KEY (`groupId`) REFERENCES `groups` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);
