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
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(150) NOT NULL,
    `notification` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create sessions table
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `session` varchar(255) NOT NULL,
    `user_agent` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Create table for user verification
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `verification` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `token` varchar(150) NOT NULL,
    `confirmed` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for images
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `images` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_name` varchar(255) NOT NULL,
    `image_data` longblob NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for comments
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_id` int(11) NOT NULL,
    `content` text NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id),
    FOREIGN KEY (`image_id`) REFERENCES images(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# Create table for likes
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `likes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `image_id` int(11) NOT NULL,
    `comment_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(id),
    FOREIGN KEY (`image_id`) REFERENCES images(id),
    FOREIGN KEY (`comment_id`) REFERENCES comments(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;