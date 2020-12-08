# ************************************************************
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.13-MariaDB)
# Database: camagru
# ************************************************************

# Create Camagru Database
# ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS camagru;
USE camagru;

# Create user table
# ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(150) NOT NULL,            
    `token` varchar(150) NOT NULL,
    `confirmed` tinyint(1) NOT NULL DEFAULT 0,
    `notification` tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create session table
# ------------------------------------------------------------
CREATE TABLE `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL,
  `session` varchar(255) NULL,
  `user_agent` varchar(255) NULL,
  PRIMARY KEY (`id`)
  FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Create table for images
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `image` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_name` varchar(255) NOT NULL,
    `image_data` longblob NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for comments
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `comment` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_id` int(11) NOT NULL,
    `content` varchar(255) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (`image_id`) REFERENCES image(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for likes
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `like` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (`image_id`) REFERENCES image(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;