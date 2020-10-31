# ************************************************************
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.13-MariaDB)
# Database: camagru
# ************************************************************

# Create Camagru Database
# ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS camagru;
USE camagru;

# Create table for users
# ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(150) NOT NULL,
    `last_name` varchar(150) NOT NULL,
    `username` varchar(150) NOT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(150) NOT NULL,
    `acl` text(255),
    `confirmed` tinyint(1) DEFAULT '0',
    `deleted` tinyint(4) DEFAULT '0',
    `notifications` tinyint(1) DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for user_sessions
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `session` varchar(255) NOT NULL,
    `user_agent` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;